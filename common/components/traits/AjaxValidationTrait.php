<?php
namespace common\components\traits;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
trait AjaxValidationTrait
{
    /**
     * Performs ajax validation.
     *
     * @param Model $model
     *
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

            // \Yii::$app->response->data   = ActiveForm::validate($model);
            // \Yii::$app->response->send();
            // \Yii::$app->end();
        }
        // if (Yii::$app->request->isAjax && $suggestionmodel->load(Yii::$app->request->post())) {
        //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //     return \yii\bootstrap5\ActiveForm::validate($suggestionmodel);
        // }
    }
}
