<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "utm".
 *
 * @property int $id
 * @property int $campaign_id
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $utm_id
 * @property string|null $utm_term
 * @property string|null $utm_content
 * @property string|null $referer
 * @property string $ip_address
 * @property string|null $device
 * @property string|null $platform
 * @property string|null $platform_version
 * @property string|null $browser
 * @property string|null $browser_version
 * @property int $isRobot
 * @property string|null $robot
 * @property string|null $session_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Utm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campaign_id', 'ip_address'], 'required'],
            [['campaign_id', 'isRobot', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['utm_source', 'utm_medium', 'utm_campaign', 'utm_id', 'utm_term', 'utm_content', 'referer', 'ip_address', 'device', 'platform', 'platform_version', 'browser', 'browser_version', 'robot', 'session_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'utm_source' => 'Utm Source',
            'utm_medium' => 'Utm Medium',
            'utm_campaign' => 'Utm Campaign',
            'utm_id' => 'Utm ID',
            'utm_term' => 'Utm Term',
            'utm_content' => 'Utm Content',
            'referer' => 'Referer',
            'ip_address' => 'Ip Address',
            'device' => 'Device',
            'platform' => 'Platform',
            'platform_version' => 'Platform Version',
            'browser' => 'Browser',
            'browser_version' => 'Browser Version',
            'isRobot' => 'Is Robot',
            'robot' => 'Robot',
            'session_id' => 'Session ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}