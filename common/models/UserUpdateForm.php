<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Update Existing User Details
 */
class UserUpdateForm extends Model
{
    public $user_model;
    public $email;
    public $username;
    public $name;
    public $password;
    public $is_adminstrator;
    public $is_admin;
    public $is_cms_manager;

    public $role_id;

    // 1 => 'Administrator',
    // 2 => 'Admin',
    // 3 => 'Safari Operator',
    // 4 => 'Operator',
    // 5 => 'Cms Manager',
    // 6 => 'Resort Manager',


    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);

        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->username = $this->user_model->username;
            $this->email = $this->user_model->email;
            $this->name = $this->user_model->name;


            $this->role_id = [];

            if ($this->user_model->is_adminstrator == 1) {
                $this->role_id[] = 1;
            }
            if ($this->user_model->is_admin == 1) {
                $this->role_id[] = 2;
            }

            if ($this->user_model->is_cms_manager == 1) {
                $this->role_id[] = 5;
            }

        }
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'email'],
            ['username', 'required'],
            //name rules
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 150],
            ['name', 'trim'],
            //last_name rules
            [
                'username',
                'unique',
                'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                },
                'targetClass' => \common\models\User::className(),
                'message' => 'This username has already been taken'
            ],
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['is_adminstrator', 'is_admin', 'is_cms_manager'], 'safe'],
            [
                'email',
                'unique',
                'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                },
                'targetClass' => \common\models\User::className(),
                'message' => 'This email address has already been taken'
            ],
            ['password', 'string', 'min' => 4],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'username' => 'Login ID',
            'password' => 'Password',
            'role_id' => 'Select User Role'
        ];
    }

    /**
     * initialize Form Data
     *
     * @return void
     */
    public function initializeForm()
    {

        if (isset($this->password) && $this->password != null && $this->password != '') {
            $this->user_model->auth_key = \Yii::$app->security->generateRandomString();
            $this->user_model->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->user_model->password_updated_at = time();
        }
        $this->user_model->username = $this->username;
        $this->user_model->email = $this->email;

        $this->user_model->is_admin = 0;
        $this->user_model->is_adminstrator = 0;

        $this->user_model->is_cms_manager = 0;

        $this->user_model->save(false);

        if ($this->role_id) {
            foreach ($this->role_id as $role) {
                if ($role == 1) {
                    $this->user_model->is_adminstrator = 1;
                }

                if ($role == 2) {
                    $this->user_model->is_admin = 1;
                }


                if ($role == 5) {
                    $this->user_model->is_cms_manager = 1;
                }

            }
        }

        $this->user_model->name = $this->name;
        $this->user_model->save(false);
    }
}
