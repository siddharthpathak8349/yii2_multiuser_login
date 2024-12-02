<?php
namespace common\validators;
use yii\validators\Validator;

class AadharValidator extends Validator
{
    public static $aadharnumberRegexp = '"^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$"';

    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute != '') {
            if (!preg_match('/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'invalid Aadhar Number');
            }
        }
    }
}
