<?php
namespace common\validators;
use yii\validators\Validator;

class NoZeroPhoneNumberValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        if (!empty($value) && substr($value, 0, 1) === '0') {
            $this->addError($model, $attribute, 'Cannot start with 0.');
        }
    }
}

?>