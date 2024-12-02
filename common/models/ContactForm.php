<?php
namespace common\models;
use common\traits\CommanRelationship;
use Yii;
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $phone
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_platform_version
 * @property string|null $user_browser
 * @property string|null $user_browser_version
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class ContactForm extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    public static function tableName()
    {
        return 'contact_form';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email', 'message', 'phone', 'status'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'user_id'], 'integer'],
            [['name', 'message', 'user_ip_address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 215],
            [['phone'], 'string', 'max' => 10],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version'], 'safe'],
            [['user_agent'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'phone' => 'Phone',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_platform_version' => 'User Platform Version',
            'user_browser' => 'User Browser',
            'user_browser_version' => 'User Browser Version',
            'user_ip_address' => 'User Ip Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
