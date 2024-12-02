<?php
namespace backend\controllers;
use common\components\AuthHandler;
use common\models\LoginForm;
use common\models\MailLog;
use common\models\User;
use frontend\models\SignupForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'file', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'auth' || $action->id == 'login') {
            $referrer = Yii::$app->request->referrer;
            if (isset($this->request->queryParams['referrer'])) {
                $referrer = $this->request->queryParams['referrer'];
            }
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'user_login_redirect',
                'value' => $referrer,
                'expire' => time() + 86400 * 365 * 365,
            ]));
        }

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            'file' => [
                'class' => \diecoding\flysystem\actions\FileAction::class,
                // 'component' => 'fs',
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->identity->backend_role != User::BACKEND_SYSTEM_ADMIN) {
            throw new UnauthorizedHttpException('You are not allowed to perform this action.');
        }

        return $this->render('index');
    }

    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }
    //     $this->layout = 'blank';
    //     $model = new LoginForm();
    //     // die("HH");
    //     // dd('ddd');

    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         $user = $model->user;
    //         // echo '<pre>';
    //         // print_r($user);
    //         // die();
    //         $to_mail = $user->email;
    //         $subject = 'User Login';
    //         $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_LOGIN;
    //         $req = ['username' => $user->name];

    //         MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //         return $this->goBack();
    //     }
    //     $model->password = '';
    //     return $this->render('@backend/views/site/login', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->user;
            $to_mail = $user->email;
            $subject = 'User Login';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_LOGIN;
            $req = ['username' => $user->name];

            MailLog::createMailLog($to_mail, $subject, $template, $req, []);

            // Check if user is a hospital admin and redirect accordingly
            if ($user->backend_role == User::BACKEND_HOSPITAL_ADMIN) {
                return $this->redirect(['hospitalportal/dashboard', 'h_id' => $user->hospital_id]);
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('@backend/views/site/login', [
            'model' => $model,
        ]);
    }

    // public function onAuthSuccess($client)
    // {
    //     $cookies = Yii::$app->request->cookies;
    //     if ($cookies->has('user_login_redirect')) {
    //         $referrer = $cookies->get('user_login_redirect')->value;
    //     } else {
    //         $referrer = Yii::$app->request->referrer;
    //     }
    //     $authHandler = new AuthHandler($client, $referrer, 'backend');
    //     $authHandler->handle();
    //     $attributes = $client->getUserAttributes();
    //     $email = $attributes['email'];
    //     $user = User::findOne(['email' => $email]);

    //     if ($user) {
    //         if ($user->backend_role == User::BACKEND_HOSPITAL_ADMIN) {
    //             return $this->redirect(['hospitalportal/dashboard', 'h_id' => $user->hospital_id]);
    //         }
    //     }
    //     return $this->redirect(['site/index']);
    // }

    public function onAuthSuccess($client)
    {
        $cookies = Yii::$app->request->cookies;

        // Check if a custom redirect URL exists in the cookies
        if ($cookies->has('user_login_redirect')) {
            $referrer = $cookies->get('user_login_redirect')->value;
        } else {
            $referrer = Yii::$app->request->referrer;
        }

        // Handle the authentication logic
        $authHandler = new AuthHandler($client, $referrer);
        $authHandler->handle();

        // Get the logged-in user from Yii's user component
        $user = Yii::$app->user->identity;

        // Check if the user exists and if the email matches
        if ($user) {
            // Check the backend role of the user and redirect accordingly
            if ($user->backend_role == User::BACKEND_HOSPITAL_ADMIN && !empty($user->hospital_id)) {
                // Redirect to the hospital portal
                return Yii::$app->response->redirect(['hospitalportal/dashboard', 'h_id' => $user->hospital_id]);
            } elseif ($user->backend_role == User::BACKEND_SYSTEM_ADMIN) {
                // Redirect to the backend admin portal
                return Yii::$app->response->redirect(['site/index']);
            }
        }

        // If no special role, redirect to the default site index
        return Yii::$app->response->redirect(['site/index']);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
