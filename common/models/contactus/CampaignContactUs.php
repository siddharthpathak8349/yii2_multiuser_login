<?php
namespace common\models\contactus;
use Yii;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $blood_group_id
 * @property int|null $model_id
 * @property int|null $user_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property int|null $age
 * @property int|null $is_live_request
 * @property int|null $is_campaign
 * @property int|null $is_static_campaign
 */
class CampaignContactUs extends \yii\db\ActiveRecord
{

    //status
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    const CAMPAIGN_MODEL = 1;


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
        return 'campaign_contact_us';
    }

    public function rules()
    {
        return [
            [['blood_group_id', 'age', 'is_live_request', 'is_campaign', 'is_static_campaign', 'model_id', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'blood_group_id' => 'Blood Group ID',
            'model_id' => 'Model ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
                $text = "Not Active";
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
}
