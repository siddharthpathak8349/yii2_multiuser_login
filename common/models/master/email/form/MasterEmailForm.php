<?php
namespace common\models\master\email\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\email\MasterEmail;
use yii\web\UploadedFile;

class MasterEmailForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $email_model;

    public function __construct(MasterEmail $email_model = null)
    {
        $this->email_model = Yii::createObject([
            'class' => MasterEmail::className()
        ]);
        if ($email_model != '') {
            $this->email_model = $email_model;
            $this->title = $this->email_model->title;
            $this->status = $this->email_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->email_model->title = $this->title;
        $this->email_model->status = $this->status;
    }

}
