<?php

namespace common\models\notification;

use Yii;

/**
 * This is the model class for table "frontend_notification".
 *
 * @property int $id
 * @property string|null $notification_url
 * @property string|null $notification_text
 * @property int $action_id
 * @property int|null $chat_id in case of notification from chat
 * @property int|null $sent_to_operator_id
 * @property string|null $sent_to_operator_name
 * @property int $status
 * @property int $is_seen 0=>not seen, 1=>Seen
 * @property int $is_read 0=>not read, 1=>Read
 * @property string|null $seen_datetime
 * @property string|null $read_datetime
 * @property int|null $delay_time
 * @property int|null $user_id
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class FrontendNotification extends \yii\db\ActiveRecord
{

    const ACTION_PACKAGE_NEW_COMMENT = 1;
    const ACTION_PACKAGE_COMMENT_REPLY = 2;
    const ACTION_OPERATOR_NEW_FOLLOWER = 3;
    const ACTION_OPERATOR_NEW_QUOTE = 4;
    const ACTION_OPERATOR_NEW_REVIEW = 5;
    const ACTION_SHARED_SAFARI_JOIN = 6;
    const ACTION_USER_NEW_FOLLOWER = 7;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frontend_notification';
    }


    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_id'], 'required'],
            [['action_id', 'chat_id', 'sent_to_operator_id', 'status', 'is_seen', 'is_read', 'delay_time', 'user_id', 'parent_id', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'integer'],
            [['seen_datetime', 'read_datetime'], 'safe'],
            [['notification_url', 'notification_text', 'sent_to_operator_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_url' => 'Notification Url',
            'notification_text' => 'Notification Text',
            'action_id' => 'Action ID',
            'chat_id' => 'Chat ID',
            'sent_to_operator_id' => 'Sent To User ID',
            'sent_to_operator_name' => 'Sent To User Name',
            'status' => 'Status',
            'is_seen' => 'Is Seen',
            'is_read' => 'Is Read',
            'seen_datetime' => 'Seen Datetime',
            'read_datetime' => 'Read Datetime',
            'delay_time' => 'Delay Time',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Short Notification Message
     *
     * @return void
     */
    public function getShortmessage()
    {
        return $this->notification_text;
    }

    public function getNoticeclass()
    {
        $class = 'notification-not-read';

        if ($this->is_read) {
            $class = 'notification-read';
        }
        return $class;
    }
}
