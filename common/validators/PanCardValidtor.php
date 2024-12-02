<?php
namespace common\validators;
use yii\validators\Validator;

class PanCardValidtor extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute != '') {
            if (!preg_match('/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid PAN number');
            }
        }
    }
}
