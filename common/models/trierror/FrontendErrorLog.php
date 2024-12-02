<?php

namespace common\models\trierror;

use Yii;

/**
 * This is the model class for table "frontend_error_log".
 *
 * @property int $id
 * @property string $request_url
 * @property string $request_type
 * @property string|null $reference_url
 * @property string $error_type
 * @property string|null $ip_address
 * @property string|null $error_msg
 * @property string|null $source
 * @property string|null $user_agent
 * @property int|null $user_session_id
 * @property int|null $created_at
 */
class FrontendErrorLog extends \yii\db\ActiveRecord
{
    public $cnt;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frontend_error_log';
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_url' => 'Request Url',
            'request_type' => 'Request Type',
            'reference_url' => 'Reference Url',
            'error_type' => 'Error Type',
            'ip_address' => 'Ip Address',
            'error_msg' => 'Error Msg',
            'source' => 'Source',
            'user_agent' => 'User Agent',
            'user_session_id' => 'User Session ID',
            'created_at' => 'Created At',
        ];
    }
}
