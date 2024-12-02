<?php
namespace common\validators;
use yii\validators\Validator;

class VoterIdValidator extends Validator
{
    public static $voterIdRegexp = '/^[A-Z]{3}[0-9]{7}$/';

    public function validateAttribute($model, $attribute)
    {
        if (!empty($model->$attribute)) {
            if (!preg_match(self::$voterIdRegexp, $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid Voter ID format');
            }
        }
    }
}
