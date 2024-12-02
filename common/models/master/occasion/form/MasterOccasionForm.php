<?php
namespace common\models\master\occasion\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\occasion\MasterOccasion;

class MasterOccasionForm extends model
{
    public $id;
    public $name;
    public $status;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => MasterOccasion::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->name = $this->formModel->name;
            $this->status = $this->formModel->status;
        }
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'match', 'pattern' => '/^[A-Za-z ]+$/', 'message' => 'Name can only contain alphabets and spaces.'],
            [['status'], 'integer'],
            [['name'], 'unique', 'on'=>'create', 'targetClass' => '\common\models\master\occasion\MasterOccasion',  'message' => 'This name has already been taken.'],
            [['name'], 'unique', 'on'=>'update', 'targetClass' => '\common\models\master\occasion\MasterOccasion',  'message' => 'This name has already been taken.', 'filter' => ['!=', 'id', $this->id]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->status = $this->status;
    }
}
