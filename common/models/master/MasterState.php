<?php
namespace common\models\master;
use Yii;
/**
 * @property int $id
 * @property string $state_name
 * @property int $country_id
 * @property string $country_code
 * @property string|null $fips_code
 * @property string|null $iso2
 * @property string|null $type
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 */
class MasterState extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_state';
    }

    public function rules()
    {
        return [
            [['state_name', 'country_id', 'country_code'], 'required'],
            [['country_id', 'flag'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['state_name', 'fips_code', 'iso2', 'wikiDataId'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 2],
            [['type'], 'string', 'max' => 191],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state_name' => 'State Name',
            'country_id' => 'Country ID',
            'country_code' => 'Country Code',
            'fips_code' => 'Fips Code',
            'iso2' => 'Iso2',
            'type' => 'Type',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'wikiDataId' => 'Wiki Data ID',
        ];
    }
}
