<?php
namespace common\models\master\email\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\email\MasterEmail;
use common\models\master\email\MasterMailTemplate;

class MasterMailTemplateForm extends model
{
    public $name;
    public $path;
    public $code;
    public $status;
    public $status_option = [];
    public $mail_template_model;


    public function __construct(MasterMailTemplate $mail_template_model = null)
    {
        $this->mail_template_model = Yii::createObject([
            'class' => MasterMailTemplate::className()
        ]);
        if ($mail_template_model != '') {
            $this->mail_template_model = $mail_template_model;
            $this->name = $this->mail_template_model->name;
            $this->path = $this->mail_template_model->path;
            $this->code = $this->mail_template_model->code;
            $this->status = $this->mail_template_model->status;
        }
        $this->status_option = GeneralModel::statusoption();
    }

    public function rules()
    {
        return [
            [['name', 'path', 'code'], 'required'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 1],
            [['name', 'path'], 'string', 'max' => 255],

        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'path' => 'Path',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->mail_template_model->name = $this->name;
        $this->mail_template_model->path = $this->path;
        $this->mail_template_model->code = $this->code;
        $this->mail_template_model->status = $this->status;
    }
}
