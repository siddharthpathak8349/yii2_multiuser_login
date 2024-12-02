<?php
namespace common\models\raiserequest\donatingblood\form;
use common\models\raiserequest\donatingblood\DonatingBlood;
use Yii;
use yii\base\Model;

class DonatingBloodForm extends DonatingBlood
{
    public $id;
    public $name;
    public $ddl_blood_seva_id;
    public $phone;
    public $hospital_id;
    public $date_of_donation;
    public $occasion_id;
    public $status;
    public $user_id;
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => DonatingBlood::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->name = $this->formModel->name;
            $this->ddl_blood_seva_id = $this->formModel->ddl_blood_seva_id;
            $this->phone = $this->formModel->phone;
            $this->hospital_id = $this->formModel->hospital_id;
            $this->date_of_donation = $this->formModel->date_of_donation;
            $this->occasion_id = $this->formModel->occasion_id;
            $this->status = $this->formModel->status;
            $this->user_id = $this->formModel->user_id;
        }
    }

    public function rules()
    {
        return [
            [['name', 'ddl_blood_seva_id', 'phone', 'hospital_id', 'occasion_id', 'date_of_donation'], 'required'],
            [['phone', 'hospital_id', 'occasion_id', 'status', 'created_by', 'user_id', 'updated_by'], 'integer'],
            [['created_at', 'updated_at',], 'safe'],
            [['ddl_blood_seva_id'], 'string', 'max' => 10],
            [['phone'], 'match', 'pattern' => '/^[1-9]\d{9}$/', 'message' => 'Number must be exactly 10 digits long and cannot start with zero.'],
            [
                ['ddl_blood_seva_id'],
                'unique',
                'targetClass' => DonatingBlood::className(),
                'message' => 'This Blood Seva ID has already been taken.',
                'filter' => function ($query) {
                    if (!$this->formModel->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->formModel->id]]);
                    }
                }
            ],
            [['date_of_donation'], 'safe'],
            [['name'], 'string', 'max' => 255],
            // [['name'], 'match', 'pattern' => '/^[A-Za-z]+$/', 'message' => 'The field can only contain letters'],
            [['name'], 'match', 'pattern' => '/^[A-Za-z\s]+$/', 'message' => 'The field can only contain letters and spaces.'],

            [['ddl_blood_seva_id'], 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'The field can only contain letters, numbers'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ddl_blood_seva_id' => 'DDL Blood Sewa ID',
            'phone' => 'Mobile Number',
            'hospital_id' => 'Hospital Name',
            'date_of_donation' => 'Date Of Donation',
            'occasion_id' => 'Occasion Of Donation',
            'status' => 'Status',
            'user_id' => 'User',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->ddl_blood_seva_id = $this->ddl_blood_seva_id;
        $this->formModel->phone = $this->phone;
        $this->formModel->hospital_id = $this->hospital_id;
        $this->formModel->date_of_donation = Yii::$app->formatter->asDatetime($this->date_of_donation, 'php:Y-m-d H:i:s');
        $this->formModel->occasion_id = $this->occasion_id;
        $this->formModel->status = $this->status;
        $this->formModel->user_id = $this->user_id;
    }
}
