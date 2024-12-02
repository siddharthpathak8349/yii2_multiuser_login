<?php
namespace common\models\raiserequest\donatingblood;
use Yii;
/**
 * @property int $id
 * @property string|null $name
 * @property int|null $ddl_blood_seva_id
 * @property int|null $phone
 * @property int|null $hospital_id
 * @property string|null $date_of_donation
 * @property int|null $occasion_id
 * @property int $status
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 */
class DonatingBlood extends \yii\db\ActiveRecord
{
    //status
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'donating_blood';
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
        ];
    }

    public function rules()
    {
        return [
            [['phone', 'hospital_id', 'occasion_id', 'user_id', 'status'], 'integer'],
            [['date_of_donation', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['ddl_blood_seva_id'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ddl_blood_seva_id' => 'DDL Blood Seva ID',
            'phone' => 'Phone',
            'hospital_id' => 'Hospital ID',
            'date_of_donation' => 'Date Of Donation',
            'occasion_id' => 'Occasion ID',
            'status' => 'Status',
            'user_id' => 'User',
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
                $text = "Suspended";
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
