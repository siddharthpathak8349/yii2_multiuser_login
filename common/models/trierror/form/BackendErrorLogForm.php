<?php

namespace common\models\trierror\form;

use common\models\trierror\BackendErrorLog;
use Yii;
use yii\base\Model;

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
class BackendErrorLogForm extends Model
{

    /**
     * {@inheritdoc}
     */
    public $id;
    public $error_report;
    public $request_url;
    public $reference_url;
    public $ip_address;
    public $request_type;
    public $error_msg;
    public $error_type;
    public $user_session_id;
    public $user_agent;
    public $backend_errorlog;
    public $isNew;
    public $distinct;
    public $cnt;


    public function __construct($model = null)
    {
        $this->backend_errorlog = \Yii::createObject([
            'class' => BackendErrorLog::className()
        ]);

        $this->isNew = true;
        if ($model != '') {
            $this->isNew = false;
            $this->backend_errorlog = $model;
            $this->id = $this->backend_errorlog->id;
            $this->error_report = $this->backend_errorlog->error_report;
            $this->request_url = $this->backend_errorlog->request_url;
            $this->reference_url = $this->backend_errorlog->reference_url;
            $this->ip_address = $this->backend_errorlog->ip_address;
            $this->request_type = $this->backend_errorlog->request_type;
            $this->error_msg = $this->backend_errorlog->error_msg;
            $this->user_session_id = $this->backend_errorlog->user_session_id;
            $this->user_agent = $this->backend_errorlog->user_agent;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_url', 'request_type', 'error_type'], 'required'],
            [['error_msg'], 'string'],
            [['user_session_id', 'created_at'], 'integer'],
            [['request_url', 'request_type', 'reference_url', 'error_type', 'ip_address', 'source', 'user_agent'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['error_type', 'request_url', 'reference_url', 'ip_address', 'user_agent', 'request_type', 'error_msg', 'user_session_id', 'source'];
        $scenarios['update'] = ['error_type', 'request_url', 'reference_url', 'ip_address', 'user_agent', 'request_type', 'error_msg', 'user_session_id', 'source'];
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
