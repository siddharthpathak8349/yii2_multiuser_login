<?php
namespace common\models\master;
use Yii;

/**
 * @property int $id
 * @property string $city_name
 * @property int $state_id
 * @property string $state_code
 * @property int $country_id
 * @property string $country_code
 * @property float $latitude
 * @property float $longitude
 * @property string $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 */
class MasterCity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_city';
    }
   
    public function rules()
    {
        return [
            [['city_name', 'state_id', 'state_code', 'country_id', 'country_code', 'latitude', 'longitude'], 'required'],
            [['state_id', 'country_id', 'flag'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['city_name', 'state_code', 'wikiDataId'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_name' => 'City Name',
            'state_id' => 'State ID',
            'state_code' => 'State Code',
            'country_id' => 'Country ID',
            'country_code' => 'Country Code',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'wikiDataId' => 'Wiki Data ID',
        ];
    }
}
