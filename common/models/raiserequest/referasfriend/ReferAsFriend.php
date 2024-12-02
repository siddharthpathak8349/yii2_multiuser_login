<?php
namespace common\models\raiserequest\referasfriend;

use common\models\master\MasterCity;
use common\models\master\MasterCountry;
use common\models\master\MasterState;
use Yii;
/**
 * @property int $id
 * @property string|null $name
 * @property int|null $phone
 * @property int|null $blood_group
 * @property int|null $state
 * @property int|null $city
 * @property string|null $location
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $user_id
 * @property int $status
 */
class ReferAsFriend extends \yii\db\ActiveRecord
{
    //status
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

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
        ];
    }

    public static function tableName()
    {
        return 'refer_as_friend';
    }

    public function rules()
    {
        return [
            [['phone', 'blood_group', 'state', 'city', 'created_by', 'updated_by', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'location'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'blood_group' => 'Blood Group',
            'state' => 'State',
            'city' => 'City',
            'location' => 'Location',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'user_id' => 'User ID',
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
                $text = "Accept";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            case self::STATUS_SUSPENDED:
                $text = "Reject";
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
        return $this->hasOne(MasterCity::className(), ['id' => 'city']);
    }
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state']);
    }
    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country']);
    }
}
