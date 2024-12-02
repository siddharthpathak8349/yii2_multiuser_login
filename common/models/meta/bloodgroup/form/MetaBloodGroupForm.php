<?php
namespace common\models\meta\bloodgroup\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\meta\bloodgroup\MetaBloodGroup;

class MetaBloodGroupForm extends model
{
    public $name;
    public $can_accept;
    public $status;
    public $status_option = [];
    public $bloodgroup_model;

    public function __construct(MetaBloodGroup $bloodgroup_model = null)
    {
        $this->bloodgroup_model = Yii::createObject([
            'class' => MetaBloodGroup::className()
        ]);
        if ($bloodgroup_model != '') {
            $this->bloodgroup_model = $bloodgroup_model;
            $this->name = $this->bloodgroup_model->name;
            $this->can_accept = $this->bloodgroup_model->can_accept;
            $this->status = $this->bloodgroup_model->status;
        }
        $this->status_option = GeneralModel::statusOption();
    }

    public function rules()
    {
        return [
            [['name', 'can_accept'], 'required'],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'can_accept' => 'Accept Blood Group',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->bloodgroup_model->name = $this->name;
        $this->bloodgroup_model->can_accept = $this->can_accept;
        $this->bloodgroup_model->status = $this->status;
    }
}
