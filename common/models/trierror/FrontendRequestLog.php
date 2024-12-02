<?php

namespace common\models\trierror;

use Yii;
use common\models\User;

/**
 * This is the model class for table "frontend_request".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $request_url
 * @property string|null $request_data
 * @property int $request_code
 * @property int $is_reqeust_trace
 * @property string $response_error
 * @property string $created_at
 */
class FrontendRequestLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_frontend_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'request_code'], 'integer'],
            [['request_data', 'response_error'], 'string'],
            [['response_error'], 'required'],
            [['created_at', 'refer_url', 'is_reqeust_trace'], 'safe'],
            [['request_url'], 'string', 'max' => 555],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'request_url' => 'Request Url',
            'request_data' => 'Request Data',
            'request_code' => 'Request Code',
            'response_error' => 'Response Error',
            'refer_url' => 'Referef URL',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
