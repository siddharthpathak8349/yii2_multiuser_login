<?php
namespace common\models\master;
use Yii;
/**
 * @property int $id
 * @property string $country_name
 * @property string|null $iso3
 * @property string|null $numeric_code
 * @property string|null $iso2
 * @property string|null $phonecode
 * @property string|null $capital
 * @property string|null $currency
 * @property string|null $currency_name
 * @property string|null $currency_symbol
 * @property string|null $tld
 * @property string|null $native
 * @property string|null $region
 * @property int|null $region_id
 * @property string|null $subregion
 * @property int|null $subregion_id
 * @property string|null $nationality
 * @property string|null $timezones
 * @property string|null $translations
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $emoji
 * @property string|null $emojiU
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 */
class MasterCountry extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'master_country';
    }
  
    public function rules()
    {
        return [
            [['country_name'], 'required'],
            [['region_id', 'subregion_id', 'flag'], 'integer'],
            [['timezones', 'translations'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['country_name'], 'string', 'max' => 100],
            [['iso3', 'numeric_code'], 'string', 'max' => 3],
            [['iso2'], 'string', 'max' => 2],
            [['phonecode', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'subregion', 'nationality', 'wikiDataId'], 'string', 'max' => 255],
            [['emoji', 'emojiU'], 'string', 'max' => 191],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_name' => 'Country Name',
            'iso3' => 'Iso3',
            'numeric_code' => 'Numeric Code',
            'iso2' => 'Iso2',
            'phonecode' => 'Phonecode',
            'capital' => 'Capital',
            'currency' => 'Currency',
            'currency_name' => 'Currency Name',
            'currency_symbol' => 'Currency Symbol',
            'tld' => 'Tld',
            'native' => 'Native',
            'region' => 'Region',
            'region_id' => 'Region ID',
            'subregion' => 'Subregion',
            'subregion_id' => 'Subregion ID',
            'nationality' => 'Nationality',
            'timezones' => 'Timezones',
            'translations' => 'Translations',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'emoji' => 'Emoji',
            'emojiU' => 'Emoji U',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'wikiDataId' => 'Wiki Data ID',
        ];
    }
}
