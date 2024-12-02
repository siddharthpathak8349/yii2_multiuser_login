<?php
namespace common\models\raiserequest\checkeligibility;

use common\models\User;
use Yii;
/**
 * @property int $id
 * @property int $user_id
 * @property int $blood_receiving_id 
 * @property int $hospital_id
 * @property int $eligibility_question_id
 * @property string|null $question 
 * @property int $answer   
 * @property int $correct_answer   
 * @property int $submit_datetime
 * @property int $status 	1=>Active, 0=>Suspend, -1=>Deleted	
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class BloodRecevingDonorEligibilityAnswer extends \yii\db\ActiveRecord
{

    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'blood_receiving_donar_eligibility_answer';
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
            [['user_id', 'blood_receiving_id', 'hospital_id', 'eligibility_question_id', 'correct_answer', 'answer'], 'required'],
            [['user_id', 'blood_receiving_id', 'hospital_id', 'eligibility_question_id', 'answer', 'correct_answer', 'status', 'created_by', 'updated_by'], 'integer'],
            [['submit_datetime'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],

            [['question'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'blood_receiving_id' => 'Blood Receiving ID',
            'hospital_id' => 'Hospital ID',
            'eligibility_question_id' => 'Eligibility Question ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'correct_answer' => 'Correct Answer',
            'submit_datetime' => 'Submit Datetime',
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

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
