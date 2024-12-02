<?php
namespace common\models\raiserequest\checkeligibility\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\raiserequest\checkeligibility\BloodRecevingDonorEligibilityAnswer;

class BloodRecevingDonorEligibilityAnswerFrom extends model
{
    public $id;
    public $user_id;
    public $blood_receiving_id;
    public $hospital_id;
    public $eligibility_question_id;
    public $question;
    public $answer;
    public $correct_answer;
    public $submit_datetime;
    public $status;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;


    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => BloodRecevingDonorEligibilityAnswer::className()
        ]);
        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->user_id = $this->formModel->user_id;
            $this->blood_receiving_id = $this->formModel->blood_receiving_id;
            $this->hospital_id = $this->formModel->hospital_id;
            $this->eligibility_question_id = $this->formModel->eligibility_question_id;
            $this->question = $this->formModel->question;
            $this->answer = $this->formModel->answer;
            $this->correct_answer = $this->formModel->correct_answer;
            $this->submit_datetime = $this->formModel->submit_datetime;
            $this->status = $this->formModel->status;
        }
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

    public function initializeForm()
    {
        $this->formModel->user_id = $this->user_id;
        $this->formModel->blood_receiving_id = $this->blood_receiving_id;
        $this->formModel->hospital_id = $this->hospital_id;
        $this->formModel->eligibility_question_id = $this->eligibility_question_id;
        $this->formModel->question = $this->question;
        $this->formModel->answer = $this->answer;
        $this->formModel->correct_answer = $this->correct_answer;
        $this->formModel->submit_datetime = $this->submit_datetime;
        $this->formModel->status = $this->status;
    }

}
