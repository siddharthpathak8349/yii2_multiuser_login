<?php
namespace common\models\raiserequest\bloodrecevingdonor;

use common\models\raiserequest\bloodreceiving\BloodReceiving;
use common\models\User;
use Yii;

/**
 * @property int $id
 * @property int|null $blood_receiving_id
 * @property int|null $donor_id log in user id is store who eligible yes and no
 * @property int|null $hospital_id
 * @property int|null $hospital_action_status
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class BloodRecevingDonorEligibilityManagement extends \yii\db\ActiveRecord
{

    const HOSPITAL_ACTION_STATUS_REJECT = -1;
    const HOSPITAL_ACTION_STATUS_PENDING = 0;
    const HOSPITAL_ACTION_STATUS_APPROVE = 1;


    public static function tableName()
    {
        return 'blood_receving_donor_eligibility_management';
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
            [['blood_receiving_id', 'donor_id', 'hospital_id', 'hospital_action_status', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blood_receiving_id' => 'Blood Receving ID',
            'donor_id' => 'Donor ID',
            'hospital_id' => 'Hospital ID',
            'hospital_action_status' => 'Hospital Action Status',
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
            case self::HOSPITAL_ACTION_STATUS_APPROVE:
                $text = "Approve";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            case self::HOSPITAL_ACTION_STATUS_REJECT:
                $text = "Reject";
                $style = "border: 1px solid #f8d5db; border-radius: 20px; font-size: $fontSize; color: #da2f49; background-color: #f8d5db; width: $width;";
                break;
            case self::HOSPITAL_ACTION_STATUS_PENDING:
                $text = "Pending";
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

    public function getDonor()
    {
        return $this->hasOne(User::class, ['id' => 'donor_id']);
    }
    public function getBloodReceiving()
    {
        return $this->hasOne(BloodReceiving::class, ['id' => 'blood_receiving_id']);
    }



}