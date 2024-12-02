<?php
namespace common\models\cms\faq;

use common\models\raiserequest\bloodreceiving\BloodReceiving;
use Yii;

/**
 * @property int $id
 * @property string $master_faq_category_id meta_faq_type
 * @property string|null $question
 * @property string|null $answer
 * @property int $sequence
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Faq extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    const Website  = 1;
    const BloodReceiving  = 2;
    const Campagion  = 3;


    public static function getTypeLabels()
    {
        return [
            self::Website => 'Website',
            self::BloodReceiving => 'Blood Receiving',
            self::Campagion => 'Campaign',
        ];
    }

    /**
     * Get the label for the current type
     */
    public function getTypeLabel()
    {
        $labels = self::getTypeLabels();
        return $labels[$this->type] ?? 'Unknown'; 
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

    public static function tableName()
    {
        return 'faq';
    }

    public function rules()
    {
        return [
            [['question', 'answer'], 'required'],
            [['answer', 'question'], 'string'],
            [['sequence','type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['master_faq_category_id'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_faq_category_id' => 'FAQ Category',
            'type' => 'Type',
            'question' => 'Question',
            'answer' => 'Answer',
            'sequence' => 'Sequence',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function statusImage()
    {
        $iconClass = NULL;
        $alt = NULL;
        if ($this->status == self::STATUS_ACTIVE) {
            $iconClass = "green-circle";
            $alt = "Enabled";
        } elseif ($this->status == self::STATUS_SUSPENDED) {
            $iconClass = "red-circle";
            $alt = "Pending";
        } elseif ($this->status == self::STATUS_DELETED) {
            $iconClass = "grey-circle";
            $alt = "Disabled";
        } else {
            echo "Unknown status: " . $this->status; 
        }

        return array(
            'iconClass' => $iconClass,
            'alt' => $alt
        );
    }
}
