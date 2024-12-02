<?php
namespace common\models;
use common\models\master\email\MasterMailTemplate;
use common\traits\CommanRelationship;
use Yii;
/**
 * @property int $id
 * @property string|null $subject
 * @property string|null $mail_template_id
 * @property string|null $params
 * @property string|null $aws_message_id
 * @property string|null $mail_send_time
 * @property int $try_send_count
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class MailLog extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
  
    public static function tableName()
    {
        return 'mail_log';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['mail_template_id', 'try_send_count', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['params'], 'string'],
            [['mail_send_time'], 'safe'],
            [['subject', 'aws_message_id'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'mail_template_id' => 'Mail Template ID',
            'params' => 'Params',
            'aws_message_id' => 'Aws Message ID',
            'mail_send_time' => 'Mail Send Time',
            'try_send_count' => 'Try Send Count',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }


    /**
     * Email Send Whenever this Function Call and Create New Entry into DB
     *
     * @return void
     */
    // public static function sendmail($title, $mail_to, $mail_from = 'admin@gmail.com', $description, $event_type, $module_name = 'MAIN')
    // {
    //     $log = new self();
    //     // $log->mail_to = $mail_to;
    //     // $log->mail_from = $mail_from;
    //     $log->status = 1; // Mail Not Send
    //     $log->params = json_encode($_REQUEST); // All Response Auto Save as JSON
    //     if ($log->save()) {
    //         // Mail Sending Query Here and Uncomment Below Lines


    //         // $log->status = 2; // Mail Send then Change Status
    //         // $log->save();
    //     }
    // }

    public static function createMailLog($mail_to, $subject, $mail_template_id, $params, $cc = [], $bcc = [])
    {
        $template = MasterMailTemplate::find()->where(['code' => $mail_template_id, 'status' => 1])->limit(1)->one();
        if ($template) {
            $mail_from = 'no-reply@walkintothewild.in';
            $log = new self();
            // $log->mail_to = $mail_to;
            // $log->mail_from = $mail_from;
            $log->subject = $subject;
            $log->mail_template_id = $template->id;
            $log->params = json_encode($params, true);
            $log->status = 2; // Mail Not Send

            if ($log->save(false)) {
                if (!empty($mail_to)) {
                    $m = new MailLogRecipients();
                    $m->mail_log_id = $log->id;
                    $m->recipient = $mail_to;
                    $m->send_as = MailLogRecipients::SEND_AS_TO_RECIPIENTS;
                    $m->save(false);
                }
                if (!empty($cc) && is_array($cc)) {
                    foreach ($cc as $c) {
                        $m = new MailLogRecipients();
                        $m->mail_log_id = $log->id;
                        $m->recipient = $c;
                        $m->send_as = MailLogRecipients::SEND_AS_CC_RECIPIENTS;
                        $m->save(false);
                    }
                }
                if (!empty($bcc) && is_array($bcc)) {
                    foreach ($bcc as $b) {
                        $m = new MailLogRecipients();
                        $m->mail_log_id = $log->id;
                        $m->recipient = $b;
                        $m->send_as = MailLogRecipients::SEND_AS_BCC_RECIPIENTS;
                        $m->save(false);
                    }
                }


                // self::sendmail($log);
            }

            return json_decode($log->params, true);
        }
    }


    public static function  sendmail($log)
    {
        $cc = [];
        $bcc = [];
        foreach ($log->ccrecipients as $c) {

            $cc[] = $c->recipient;
        }

        foreach ($log->bccrecipients as $b) {

            $bcc[] = $b->recipient;
        }

        if ($log->mail_template_id) {
            $template = MasterMailTemplate::find()->where(['id' => $log->mail_template_id, 'status' => 1])->limit(1)->one();
            if ($template) {
                $mailer =  \Yii::$app->mailer;
                $message = $mailer->compose($template->path, json_decode($log->params, true))
                    // ->setFrom($log->mail_from)
                    ->setFrom('no-reply@walkintothewild.in')
                    ->setTo($log->torecipient->recipient)
                    ->setBcc($bcc)
                    ->setCc($cc)
                    ->setSubject($log->subject)
                    ->send();

                if ($message) {
                    $m = MailLog::find()->where(['id' => $log->id])->one();

                    $id = $mailer->getSentMessage()->getMessageId();
                    $m->aws_message_id = $id;
                    $m->try_send_count = $m->try_send_count + 1;
                    $m->status = true;
                    $m->mail_send_time = date('Y-m-d H:i:s');
                    $m->save(false);
                    MailLogRecipients::updateAll([
                        'aws_message_id' => $id,
                    ], ['mail_log_id' => $log->id]);
                }
            }
        }
    }

    public function getTorecipient()
    {
        return $this->hasOne(MailLogRecipients::className(), ['mail_log_id' => 'id'])->where(['send_as' => MailLogRecipients::SEND_AS_TO_RECIPIENTS]);
    }

    public function getCcrecipients()
    {
        return $this->hasMany(MailLogRecipients::className(), ['mail_log_id' => 'id'])->where(['send_as' => MailLogRecipients::SEND_AS_CC_RECIPIENTS]);
    }

    public function getBccrecipients()
    {
        return $this->hasMany(MailLogRecipients::className(), ['mail_log_id' => 'id'])->where(['send_as' => MailLogRecipients::SEND_AS_BCC_RECIPIENTS]);
    }

    public function getTemplate()
    {
        return $this->hasOne(MasterMailTemplate::className(), ['id' => 'mail_template_id']);
    }
}
