<?php
namespace common\validators;
use yii\validators\Validator;

class DrivingLicenseValidator extends Validator
{
    public static $drivingLicenseRegexp = '/^[A-Z]{2}[0-9]{2}[0-9]{11}$/';

    public function validateAttribute($model, $attribute)
    {
        if (!empty($model->$attribute)) {
            if (!preg_match(self::$drivingLicenseRegexp, $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid Driving License Number format');
            }
        }
    }
}
