<?php
namespace common\models;
use common\models\master\hospital\MasterHospital;
use common\models\master\MasterCity;
use common\models\master\MasterCountry;
use common\models\master\MasterState;
use common\models\master\occasion\MasterOccasion;
use common\models\meta\bloodgroup\MetaBloodGroup;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class GeneralModel extends Model implements \common\interfaces\StatusInterface
{

    public static function statusOption()
    {
        return [self::STATUS_ACTIVE => 'Active', self::STATUS_SUSPEND => 'Suspend'];
    }

    public static function countryOption()
    {
        return ArrayHelper::map(MasterCountry::find()->orderBy(['country_name' => SORT_ASC])->all(), 'id', 'country_name');
    }

    public static function getStateCountryWise($countryId)
    {
        return ArrayHelper::map(MasterState::find()->where(['country_id' => $countryId])->orderBy(['state_name' => SORT_ASC])->all(), 'id', 'state_name');
    }

    public static function getCityStateWise($state_id)
    {
        return ArrayHelper::map(MasterCity::find()->where(['state_id' => $state_id])->orderBy(['city_name' => SORT_ASC])->all(), 'id', 'city_name');
    }

    public static function getHospital()
    {
        return ArrayHelper::map(MasterHospital::find()->where(['status' => true])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function getOccasion()
    {
        return ArrayHelper::map(MasterOccasion::find()->where(['status' => true])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function getBloodgroup()
    {
        return ArrayHelper::map(MetaBloodGroup::find()->where(['status' => true])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function pages()
    {
        return [
            1 => 'Hospital',
            2 => 'About Us',
            3 => 'Privacy Policy',
            4 => 'Blood Donor',
            5 => 'Blood Receiver',
            6 => 'Doctor',
            7 => 'Counsellor',
            8 => 'Dietician',
            9 => 'Testimonial',

        ];
    }
}
