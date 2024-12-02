<?php

namespace common\models\trierror\form;

use Yii;
use yii\base\Model;
use common\models\trierror;
use common\models\trierror\ErrorLog;

/**
 * This is the model class for table "ErrorLog".
 *
 * @property int $id
 * @property string|null $error_report
 * @property string|null $request_url
 * @property string|null $reference_url
 * @property string|null $ip_address
 * @property string|null $request_type
 * @property string|null $error_msg
 */
class ErrorLogForm extends Model
{

    /**
     * {@inheritdoc}
     */
    public $id;
    public $panel_type_id;
    public $error_report;
    public $request_url;
    public $reference_url;
    public $ip_address;
    public $request_type;
    public $error_msg;
    public $error_type;
    public $user_session_id;
    public $errorlog;
    public $isNew;
    public $distinct;
    public $cnt;


    public function __construct($model = null)
    {
        $this->errorlog = \Yii::createObject([
            'class' => ErrorLog::className()
        ]);

        $this->isNew = true;
        if ($model != '') {
            $this->isNew = false;
            $this->errorlog = $model;
            $this->id = $this->errorlog->id;
            $this->error_report = $this->errorlog->error_report;
            $this->panel_type_id = $this->errorlog->panel_type_id;
            $this->request_url = $this->errorlog->request_url;
            $this->reference_url = $this->errorlog->reference_url;
            $this->ip_address = $this->errorlog->ip_address;
            $this->request_type = $this->errorlog->request_type;
            $this->error_msg = $this->errorlog->error_msg;
            $this->user_session_id = $this->errorlog->user_session_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['error_type', 'panel_type_id'], 'integer'],
            [['request_url', 'reference_url',], 'url'],
            [['ip_address'], 'required'],
            [['request_type'], 'string', 'max' => 255],
            [['error_msg', 'reference_url', 'user_session_id', 'source'], 'safe']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['error_type', 'panel_type_id', 'request_url', 'reference_url', 'ip_address', 'request_type', 'error_msg', 'user_session_id', 'source'];
        $scenarios['update'] = ['error_type', 'panel_type_id', 'request_url', 'reference_url', 'ip_address', 'request_type', 'error_msg', 'user_session_id', 'source'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'error_type'            => 'Error Type',
            'request_url'           => 'Request URL',
            'reference_url'         => 'Reference URL',
            'ip_address'            => 'IP Address',
            'request_type'          => 'Request Type',
            'error_msg'             => 'Error Message',
            'user_session_id'       => 'User Id',
        ];
    }
}
