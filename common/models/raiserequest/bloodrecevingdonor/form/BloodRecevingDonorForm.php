<?php
namespace common\models\raiserequest\bloodrecevingdonor\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\raiserequest\bloodrecevingdonor\BloodRecevingDonor;

class BloodRecevingDonorForm extends model
{
    public $id;
    public $user_id;
    public $blood_receving_id;
    public $status;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => BloodRecevingDonor::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->user_id = $this->formModel->user_id;
            $this->blood_receving_id = $this->formModel->blood_receving_id;
            $this->status = $this->formModel->status;
        }
    }

    public function rules()
    {
        return [
            [['status', 'blood_receving_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blood_receving_id' => 'Blood Receving ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->blood_receving_id = $this->blood_receving_id;
        $this->formModel->user_id = $this->user_id;
        $this->formModel->status = $this->status;
    }
}
