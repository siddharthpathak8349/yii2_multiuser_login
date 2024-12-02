<?php
namespace common\models\raiserequest\referasfriend\form;
use common\models\raiserequest\referasfriend\ReferAsFriend;

class ReferAsFriendForm extends ReferAsFriend
{
    public $id;
    public $name;
    public $phone;
    public $blood_group;
    public $state;
    public $city;
    public $user_id;
    public $location;
    public $status;
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => ReferAsFriend::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->name = $this->formModel->name;
            $this->phone = $this->formModel->phone;
            $this->blood_group = $this->formModel->blood_group;
            $this->state = $this->formModel->state;
            $this->city = $this->formModel->city;
            $this->location = $this->formModel->location;
            $this->status = $this->formModel->status;
            $this->user_id = $this->formModel->user_id;
        }
    }

    public function rules()
    {
        return [
            [['name', 'phone', 'blood_group', 'state', 'city'], 'required'],
            [['phone', 'blood_group', 'state', 'city', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'location'], 'string', 'max' => 255],
            [['phone'], 'match', 'pattern' => '/^[1-9]\d{9}$/', 'message' => 'Phone number must be exactly 10 digits long and cannot start with zero.'],
            [['name'], 'match', 'pattern' => '/^[A-Za-z\s]+$/', 'message' => 'The name field can only contain letters and spaces.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Mobile Number',
            'blood_group' => 'Blood Group',
            'state' => 'State',
            'city' => 'City',
            'location' => 'Location',
            'status' => 'Status',
            'user_id' => 'User',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->phone = $this->phone;
        $this->formModel->blood_group = $this->blood_group;
        $this->formModel->state = $this->state;
        $this->formModel->city = $this->city;
        $this->formModel->location = $this->location;
        $this->formModel->status = $this->status;
        $this->formModel->user_id = $this->user_id;
    }
}
