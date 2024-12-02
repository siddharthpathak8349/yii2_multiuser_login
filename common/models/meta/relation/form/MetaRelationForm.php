<?php
namespace common\models\meta\relation\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\meta\relation\MetaRelation;

class MetaRelationForm extends MetaRelation
{
    public $name;
    public $status;
    public $status_option = [];
    public $formModel;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => MetaRelation::className()
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
            [['name'], 'unique', 'on' => 'create', 'targetClass' => '\common\models\master\counsellorcategory\MasterCounsellorCategory', 'targetAttribute' => 'name', 'message' => 'This name has already been taken.'],
            [['name'], 'unique', 'on' => 'update', 'targetClass' => '\common\models\master\counsellorcategory\MasterCounsellorCategory', 'targetAttribute' => 'name', 'message' => 'This name has already been taken.', 'filter' => ['!=', 'id', $this->id]],
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
