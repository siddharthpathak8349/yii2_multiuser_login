<?php
namespace common\models\master\hospitaleligibilityquestion;

use common\models\master\hospital\MasterHospital;
use common\models\master\hospitaleligibilityquestioncategory\MasterHospitalEligibilityQuestionCategory;
use common\models\master\hospitalregestration\HospitalRegestration;
use Yii;
/**
 * @property int $id
 * @property int $hospital_id
 * @property int $category
 * @property string|null $question
 * @property int $status 	1=>Active, 0=>Suspend, -1=>Deleted	
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $answer
 * @property int|null $gender
 */
class MasterHospitalEligibilityQuestion extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'master_hospital_eligibility_questions';
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
            [['hospital_id', 'category', 'answer', 'gender', 'question'], 'required'],
            [['hospital_id', 'category', 'answer', 'gender', 'status', 'created_by', 'updated_by'], 'integer'],
            [['question'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
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
            'hospital_id' => 'Hospital ID',
            'category' => 'Category',
            'question' => 'Question',
            'status' => 'Status',
            'answer' => 'Answer',
            'gender' => 'Gender',
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
    public static function getHospital()
    {
        return HospitalRegestration::find()->select(['name_of_hospital', 'id'])->indexBy('id')->column();
    }

    public static function getQuestionCategories()
    {
        return MasterHospitalEligibilityQuestionCategory::find()->select(['name', 'id'])->indexBy('id')->column();
    }

}
