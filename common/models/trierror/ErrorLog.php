<?php

namespace common\models\trierror;


use Yii;
use yii\helpers\Json;
use yii\web\ErrorHandler;
use Exception;

/**
 * This is the model class for table "error_report".
 *
 * @property int $id
 * @property string|null $error_report
 * @property string|null $request_url
 * @property string|null $reference_url
 * @property string|null $ip_address
 * @property string|null $request_type
 * @property string|null $error_msg
 * @property int|null $user_session_id
 */
class ErrorLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $cnt;
    public static function tableName()
    {
        return 'error_log';
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
            [['error_msg', 'reference_url', 'user_session_id'], 'safe']
        ];
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
