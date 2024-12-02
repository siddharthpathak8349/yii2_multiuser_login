<?php
namespace common\models\master\hospitaleligibilityquestion\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\hospitaleligibilityquestion\MasterHospitalEligibilityQuestion;

class MasterHospitalEligibilityQuestionForm extends model
{

    public $id;
    public $hospital_id;
    public $category;
    public $question;
    public $status;
    public $answer;
    public $gender;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => MasterHospitalEligibilityQuestion::className()
        ]);

        $this->isNewRecord = true;

        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->hospital_id = $this->formModel->hospital_id;
            $this->category = $this->formModel->category;
            $this->question = $this->formModel->question;
            $this->status = $this->formModel->status;
            $this->answer = $this->formModel->answer;
            $this->gender = $this->formModel->gender;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['hospital_id', 'category', 'answer', 'gender', 'question', 'status'];
        $scenarios['update'] = ['hospital_id', 'category', 'answer', 'gender', 'status', 'question'];
        return $scenarios;
    }
    public function rules()
    {
        return [
            [['hospital_id', 'category', 'answer', 'gender', 'question'], 'required'],
            [['hospital_id', 'category', 'answer', 'gender', 'status'], 'integer'],
            [['question'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hospital_id' => 'Hospital ID',
            'category' => 'Category',
            'question' => 'Question',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'answer' => 'Answer',
            'gender' => 'Gender',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        $this->initializeForm();
        if ($this->formModel->save()) {
            $this->formModel->save(false);
            return true;
        }
        return false;
    }

    public function initializeForm()
    {
        $this->formModel->hospital_id = $this->hospital_id;
        $this->formModel->category = $this->category;
        $this->formModel->question = $this->question;
        $this->formModel->status = $this->status;
        $this->formModel->answer = $this->answer;
        $this->formModel->gender = $this->gender;
    }

}
