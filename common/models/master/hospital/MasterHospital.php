<?php
namespace common\models\master\hospital;
use common\models\master\MasterCity;
use common\models\master\MasterCountry;
use common\models\master\MasterState;
use Yii;

/**
 * @property int $id
 * @property string|null $name
 * @property int|null $phone
 * @property string|null $bussiness_email_id
 * @property string|null $address
 * @property string|null $country_id
 * @property string|null $country_name
 * @property string|null $state_id
 * @property string|null $state_name
 * @property string|null $city_id
 * @property string|null $city_name
 * @property int $status 1=>Active, 0=>Suspend, -1=>Deleted	
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MasterHospital extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'master_hospital';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug',  
                'attribute' => 'name',  
                'maxLength' => 255,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                ]
            ]
        ];
    }

    public function rules()
    {
        return [
            [['phone', 'status', 'created_by', 'state_id', 'country_id', 'city_id', 'updated_by', 'country_id'], 'integer'],
            [['name', 'bussiness_email_id', 'address', 'state_name', 'city_name', 'country_name'], 'string', 'max' => 255],
        ];
    }
    public function defaultScope($value = true)
    {
        if ($value == true) {
            return $this->andWhere(['!=', 'status', self::STATUS_DELETED]);
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'bussiness_email_id' => 'Bussiness Email ID',
            'address' => 'Full Address',
            'country_id' => 'Country Id',
            'country_name' => 'Country Name',
            'state_id' => 'State Id',
            'state_name' => 'State Name',
            'city_id' => 'City Id',
            'city_name' => 'City Name',
            'status' => 'Status',
        ];
    }

    public function statusImage()
    {
        $text = NULL;
        $style = NULL;
        $width = "135px";
        $fontSize = "14px";

        switch ($this->status) {
            case self::STATUS_ACTIVE:
                $text = "Active";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            case self::STATUS_SUSPENDED:
                $text = "Suspend";
                $style = "border: 1px solid #f8d5db; border-radius: 20px; font-size: $fontSize; color: #da2f49; background-color: #f8d5db; width: $width;";
                break;
            case self::STATUS_DELETED:
                $text = "Deleted";
                $style = "border: 1px solid black; border-radius: 20px; font-size: $fontSize; color: black; background-color: #B3B3B3; width: $width;";
                break;
            default:
                return "";
        }

        if (!empty($text)) {
            return "<div style='display: inline-block; padding: 5px; text-align: center; $style'>$text</div>";
        }
        return "";
    }

    public function getCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'city_id']);
    }
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country_id']);
    }
}
