<?php
namespace common\validators;
use yii\validators\Validator;

class PassportValidator extends Validator
{
    public static $passportRegexp = '/^[A-Z]{1}[0-9]{7}$/';

    public function validateAttribute($model, $attribute)
    {
        if (!empty($model->$attribute)) {
            if (!preg_match(self::$passportRegexp, $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid Passport Number format');
            }
        }
    }
}
