<?php
namespace common\models\master\hospital\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\hospital\MasterHospital;

class MasterHospitalForm extends model
{
    public $name;
    public $phone;
    public $bussiness_email_id;
    public $address;
    public $country_id;
    public $country_name;
    public $state_id;
    public $state_name;
    public $city_id;
    public $city_name;
    public $status;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => MasterHospital::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->name = $this->formModel->name;
            $this->phone = $this->formModel->phone;
            $this->bussiness_email_id = $this->formModel->bussiness_email_id;
            $this->address = $this->formModel->address;
            $this->country_id = $this->formModel->country_id;
            $this->country_name = $this->formModel->country_name;
            $this->state_id = $this->formModel->state_id;
            $this->state_name = $this->formModel->state_name;
            $this->city_id = $this->formModel->city_id;
            $this->city_name = $this->formModel->city_name;
            $this->status = $this->formModel->status;
        }
    }

    public function rules()
    {
        return [
            [['name', 'phone', 'bussiness_email_id', 'address', 'country_id', 'state_id', 'city_id'], 'required'],
            [['status'], 'integer'],
            [['bussiness_email_id'], 'email'],
            [['phone'], 'string', 'min' => 10, 'max' => 10, 'message' => 'Should be 10 digit long.'],
            [['phone'], \common\validators\NoZeroPhoneNumberValidator::class],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9\s ]+$/', 'message' => 'Name can only contain alphabets and spaces.'],
            [['name', 'bussiness_email_id', 'address', 'country_name', 'state_name', 'city_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'bussiness_email_id' => 'Bussiness Email ID',
            'address' => 'Full Address',
            'country_id' => 'Country',
            'country_name' => 'Country Name',
            'state_id' => 'State',
            'state_name' => 'State Name',
            'city_id' => 'City',
            'city_name' => 'City Name',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->phone = $this->phone;
        $this->formModel->bussiness_email_id = $this->bussiness_email_id;
        $this->formModel->address = $this->address;
        $this->formModel->country_id = $this->country_id;
        $this->formModel->country_name = $this->country_name;
        $this->formModel->state_id = $this->state_id;
        $this->formModel->state_name = $this->state_name;
        $this->formModel->city_id = $this->city_id;
        $this->formModel->city_name = $this->city_name;
        $this->formModel->status = $this->status;
    }
}
