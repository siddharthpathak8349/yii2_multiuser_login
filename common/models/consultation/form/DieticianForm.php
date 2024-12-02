<?php
namespace common\models\consultation\form;
use common\models\consultation\Dietician;
use common\validators\NoZeroPhoneNumberValidator;
use Yii;
use yii\base\Model;

class DieticianForm extends Dietician
{
    public $id;
    public $name;
    public $ddl_blood_seva_id;
    public $phone;
    public $inquiry;
    public $type;
    public $category;
    public $status;
    public $formModel;
    public $isNewRecord;
    public $user_id;


    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => Dietician::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->name = $this->formModel->name;
            $this->ddl_blood_seva_id = $this->formModel->ddl_blood_seva_id;
            $this->phone = $this->formModel->phone;
            $this->type = $this->formModel->type;
            $this->inquiry = $this->formModel->inquiry;
            $this->category = $this->formModel->category;
            $this->status = $this->formModel->status;
            $this->user_id = $this->formModel->user_id;

        }
    }

    public function rules()
    {
        return [
            [['name', 'ddl_blood_seva_id', 'phone', 'inquiry', 'category'], 'required'],
            [['phone', 'status', 'created_by', 'updated_by', 'user_id', 'category'], 'integer'],
            [['created_at', 'updated_at',], 'safe'],
            [['ddl_blood_seva_id'], 'string', 'max' => 10],
            [['type'], 'string', 'max' => 20],
            [
                ['ddl_blood_seva_id'],
                'unique',
                'targetClass' => Dietician::className(),
                'message' => 'This Blood Seva ID has already been taken.',
                'filter' => function ($query) {
                    if (!$this->formModel->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->formModel->id]]);
                    }
                }
            ],
            [['name', 'inquiry'], 'string', 'max' => 255],
            [['name'], 'match', 'pattern' => '/^[A-Za-z\s]+$/', 'message' => 'The field can only contain letters and spaces'],
            [['ddl_blood_seva_id'], 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'The field can only contain letters, numbers'],
            [['phone'], 'string', 'min' => 10, 'max' => 10, 'message' => 'Should be 10 digit long.'],
            ['phone', NoZeroPhoneNumberValidator::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ddl_blood_seva_id' => 'DDL Blood Sewa ID',
            'phone' => 'WhatsApp Number',
            'type' => 'Type',
            'inquiry' => 'Inquiry',
            'category' => 'Category',
            'status' => 'Status',
            'user_id' => 'User',

        ];
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->ddl_blood_seva_id = $this->ddl_blood_seva_id;
        $this->formModel->phone = $this->phone;
        $this->formModel->inquiry = $this->inquiry;
        $this->formModel->category = $this->category;
        $this->formModel->status = $this->status;
        $this->formModel->type = $this->type;
        $this->formModel->user_id = $this->user_id;


    }
}
