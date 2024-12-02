<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mail_log_recipients".
 *
 * @property int $id
 * @property int $mail_log_id
 * @property string|null $aws_message_id
 * @property int $send_as 1=>to,2=>cc,3=>bcc
 * @property string $recipient
 * @property int $is_delivery notification from aws	
 * @property int $is_bounce notification from aws	
 * @property int $is_complaint notification from aws	
 * @property int $created_at
 * @property int $updated_at
 */
class MailLogRecipients extends \yii\db\ActiveRecord
{
    const SEND_AS_TO_RECIPIENTS = 1;
    const SEND_AS_CC_RECIPIENTS = 2;
    const SEND_AS_BCC_RECIPIENTS = 3;

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            
        ];
    }
    
    /**
     * {@inheritdoc}
     */
     public static function tableName()
    {
        return  'mail_log_recipients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail_log_id', 'send_as', 'recipient', 'created_at', 'updated_at'], 'required'],
            [['mail_log_id', 'send_as', 'is_delivery', 'is_bounce', 'is_complaint', 'created_at', 'updated_at'], 'integer'],
            [['aws_message_id', 'recipient'], 'string', 'max' => 255],
            [['mail_log_id', 'recipient'], 'unique', 'targetAttribute' => ['mail_log_id', 'recipient']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail_log_id' => 'Mail Log ID',
            'aws_message_id' => 'Aws Message ID',
            'send_as' => 'Send As',
            'recipient' => 'Recipient',
            'is_delivery' => 'Is Delivery',
            'is_bounce' => 'Is Bounce',
            'is_complaint' => 'Is Complaint',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
