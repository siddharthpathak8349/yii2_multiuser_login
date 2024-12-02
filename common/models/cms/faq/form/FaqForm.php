<?php
namespace common\models\cms\faq\form;
use common\models\cms\faq\Faq;
use Yii;
use yii\base\Model;

/**
 * @property int $id
 * @property string $master_faq_category_id 
 * @property string|null $question
 * @property string|null $answer
 * @property int $sequence
 * @property int $type
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class FaqForm extends Faq
{
    public $id;
    public $master_faq_category_id;
    public $question;
    public $answer;
    public $sequence;
    public $type;
    public $status;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = Yii::createObject([
            'class' => Faq::className()
        ]);
        $this->isNewRecord = true;
        if ($model !== null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->master_faq_category_id = $this->formModel->master_faq_category_id;
            $this->type = $this->formModel->type;
            $this->question = $this->formModel->question;
            $this->answer = $this->formModel->answer;
            $this->status = $this->formModel->status;
        }
    }

    public function rules()
    {
        return [
            [['question', 'answer', 'master_faq_category_id','type'], 'required'],
            [['status','type', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['question', 'answer', 'master_faq_category_id'], 'string'],
            [['status'], 'default', 'value' => 1],

        ];
    }

    public function attributeLabels()
    {
        return [
            'question' => 'Question',
            'type' => 'Type',
            'answer' => 'Answer',
            'master_faq_category_id' => 'Faq Category',
            'status' => 'Status',

        ];
    }

    public function save($runValidation = true, $attributequestions = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        $this->initializeForm();
        return $this->formModel->save();
    }

    protected function initializeForm()
    {
        $this->formModel->question = $this->question;
        $this->formModel->type = $this->type;
        $this->formModel->answer = $this->answer;
        $this->formModel->master_faq_category_id = $this->master_faq_category_id;
        $this->formModel->status = $this->status;
    }
}
