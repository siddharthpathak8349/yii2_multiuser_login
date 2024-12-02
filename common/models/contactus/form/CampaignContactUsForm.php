<?php
namespace common\models\contactus\form;

use common\models\contactus\CampaignContactUs;
use common\validators\NoZeroPhoneNumberValidator;
use Yii;
use yii\base\Model;

class CampaignContactUsForm extends Model
{
    public $id;
    public $name;
    public $address;
    public $email;
    public $phone;
    public $age;
    public $blood_group_id;
    public $model_id;
    public $status;
    public $is_live_request;
    public $is_campaign;
    public $is_static_campaign;
    public $user_id;

    public $isNewRecord;
    public $formModel;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => CampaignContactUs::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->name = $this->formModel->name;
            $this->address = $this->formModel->address;
            $this->email = $this->formModel->email;
            $this->phone = $this->formModel->phone;
            $this->age = $this->formModel->age;
            $this->blood_group_id = $this->formModel->blood_group_id;
            $this->model_id = $this->formModel->model_id;
            $this->status = $this->formModel->status;
            $this->user_id = $this->formModel->user_id;

            $this->is_live_request = $this->formModel->is_live_request;
            $this->is_campaign = $this->formModel->is_campaign;
            $this->is_static_campaign = $this->formModel->is_static_campaign;
        }
    }

    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'blood_group_id'], 'required'],
            [['status', 'user_id', 'blood_group_id', 'age', 'is_live_request', 'is_campaign', 'is_static_campaign', 'model_id'], 'integer'],
            // [['blood_group_id', 'model_id', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],

            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            ['email', 'email'],
            [['phone'], 'string', 'min' => 10, 'max' => 10, 'message' => 'Should be 10 digit long.'],
            ['phone', NoZeroPhoneNumberValidator::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'blood_group_id' => 'Blood Group',
            'model_id' => 'Model',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->address = $this->address;
        $this->formModel->email = $this->email;
        $this->formModel->phone = $this->phone;
        $this->formModel->age = $this->age;
        $this->formModel->blood_group_id = $this->blood_group_id;
        $this->formModel->model_id = $this->model_id;

        $this->formModel->is_live_request = $this->is_live_request ?? 0;
        $this->formModel->is_campaign = $this->is_campaign ?? 0;
        $this->formModel->is_static_campaign = $this->is_static_campaign ?? 0;


        $this->formModel->status = $this->status ?? CampaignContactUs::STATUS_ACTIVE;
        $this->formModel->user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->id;
    }
}