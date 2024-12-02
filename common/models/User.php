<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UserHandleBehavior;
use common\models\raiserequest\bloodreceiving\BloodReceiving;
use common\models\sharesafari\ShareSafari;

/**
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $mobile_no
 * @property string $email
 * @property string|null $token_key
 * @property string|null $verification_token
 * @property string $password_hash
 * @property string $auth_key
 * @property int $is_adminstrator
 * @property int $is_admin
 * @property int $is_cms_manager
 * @property string|null $avatar
 * @property string|null $gmail
 * @property string|null $google_source_id
 * @property string|null $profile_image
 * @property string|null $cover_image
 * @property string|null $user_handle
 * @property string|null $facebook_url
 * @property string|null $whatsapp_url
 * @property string|null $x_url
 * @property string|null $insta_url
 * @property string|null $about
 * @property string|null $user_bio
 * @property string|null $date_of_birth
 * @property int|null $gender
 * @property int|null $age
 * @property string|null $blood_group
 * @property string|null $profession
 * @property string|null $role
 * @property string|null $have_you_donated_before
 * @property string|null $when_did_you_donate
 * @property string|null $type_of_donation
 * @property string|null $donation_option

 * @property string|null $state
 * @property string|null $city
 * @property string|null $pincode
 * @property string|null $local_address
 * @property string|null $land_mark
 * @property int $agree_term_condition
 * @property int $is_system_user
 * @property int|null $blocked_at
 * @property int|null $account_type
 * @property int|null $password_updated_at
 * @property int $created_at
 * @property int $updated_at 
 * @property int $status 
 * @property int $hospital_id
 * @property int $backend_role
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ROLE_ADMINISTRATOR = 1;

    const ROLE_DONER = 1;
    const ROLE_RECIVER = 2;

    const BACKEND_SYSTEM_ADMIN = 1;
    const BACKEND_IS_ADMIN = 1;
    const ROLE = 1;
    const BACKEND_HOSPITAL_ADMIN = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => UserHandleBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'user_handle',
                'ensureUnique' => true,
                'separator' => '_'
            ],
            TimestampBehavior::class,
            // 'slug' => [
            //     'class' => 'skeeks\yii2\slug\SlugBehavior',
            //     'slugAttribute' => 'user_handle', //The attribute to be generated
            //     'attribute' => 'name', //The attribute from which will be generated
            //     'maxLength' => 255,
            //     'ensureUnique' => true,
            //     'slugifyOptions' => [
            //         'lowercase' => true,
            //         'separator' => '_',
            //         'trim' => true
            //     ]
            // ]
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['email', 'password_hash', 'auth_key'], 'required'],
            // [[ 'email', 'password_hash', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['is_adminstrator', 'is_admin', 'is_cms_manager', 'gender', 'age', 'agree_term_condition', 'is_system_user', 'blocked_at', 'account_type', 'password_updated_at', 'created_at', 'updated_at', 'status', 'backend_role', 'hospital_id'], 'integer'],
            [['about'], 'string'],
            [['date_of_birth'], 'safe'],
            [['is_adminstrator', 'is_admin', 'is_cms_manager', 'name'], 'safe'],
            [['user_handle', 'user_bio'], 'safe'],
            [['username', 'email', 'token_key', 'verification_token', 'avatar', 'gmail', 'google_source_id', 'profile_image', 'user_bio', 'blood_group', 'profession', 'role', 'have_you_donated_before', 'when_did_you_donate', 'type_of_donation', 'donation_option', 'state', 'city', 'pincode', 'local_address', 'land_mark'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 150],
            [['mobile_no'], 'string', 'max' => 15],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['cover_image', 'user_handle', 'facebook_url', 'whatsapp_url', 'x_url', 'insta_url'], 'string', 'max' => 512],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'token_key' => 'Token Key',
            'verification_token' => 'Verification Token',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'is_adminstrator' => 'Is Adminstrator',
            'is_admin' => 'Is Admin',
            'is_cms_manager' => 'Is Cms Manager',
            'avatar' => 'Avatar',
            'gmail' => 'Gmail',
            'google_source_id' => 'Google Source ID',
            'profile_image' => 'Profile Image',
            'cover_image' => 'Cover Image',
            'user_handle' => 'User Handle',
            'facebook_url' => 'Facebook Url',
            'whatsapp_url' => 'Whatsapp Url',
            'x_url' => 'X Url',
            'insta_url' => 'Insta Url',
            'about' => 'About',
            'user_bio' => 'User Bio',
            'date_of_birth' => 'Date Of Birth',
            'gender' => 'Gender',
            'age' => 'Age',
            'blood_group' => 'Blood Group',
            'profession' => 'Profession',
            'role' => 'Role',
            'have_you_donated_before' => 'Have You Donated Before',
            'when_did_you_donate' => 'When Did You Donate',
            'type_of_donation' => 'Type Of Donation',
            'donation_option' => 'Donation Option',
            // 'id_type' => 'Id Type',
            // 'id_no' => 'Id No',
            // 'id_document' => 'Id Document',
            'state' => 'State',
            'city' => 'City',
            'pincode' => 'Pincode',
            'local_address' => 'Local Address',
            'land_mark' => 'Land Mark',
            'agree_term_condition' => 'Agree Term Condition',
            'is_system_user' => 'Is System User',
            'blocked_at' => 'Blocked At',
            'account_type' => 'Account Type',
            'password_updated_at' => 'Password Updated At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'hospital_id' => 'Assign Hospital ID',
            'backend_role' => 'Backend Role',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsernameFrontend($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => $username, 'status' => self::STATUS_ACTIVE])
            ->andWhere([
                'OR',
                ['is_adminstrator' => 1],
                ['is_admin' => 1],
                ['is_cms_manager' => 1],

            ])
            ->one();
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('token_key', \Yii::$app->security->generateRandomString(32));
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof \yii\web\Application) {
                // $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        return parent::beforeSave($insert);
    }

    public function block()
    {
        return (bool) $this->updateAttributes(['blocked_at' => time(), 'status' => User::STATUS_INACTIVE]);
    }

    public function unblock()
    {
        return (bool) $this->updateAttributes(['blocked_at' => null, 'status' => User::STATUS_ACTIVE]);
    }

    public function getIsBlocked()
    {
        return $this->blocked_at != null;
    }

    public function getIsCascade()
    {
        return $this->cascade_at != null;
    }

    public function cascade()
    {
        return (bool) $this->updateAttributes(['cascade_at' => time()]);
    }

    public function uncascade()
    {
        return (bool) $this->updateAttributes(['cascade_at' => null]);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPasswordupdatedays()
    {
        if ($this->password_update_at != null) {
            $curent_time = time();
            $diff = $curent_time - $this->password_update_at;
            return ceil(abs($diff / 86400));
        }
        return 365;
    }
    // public function getPosts()
    // {
    //     return $this->hasMany(User::className(), ['user_id' => 'id']);
    // }

    public function getCheck($attribute)
    {

        if ($this->$attribute == 1) {
            return true;
        }

        return false;
    }

    public function getUserhandle()
    {
        return "@" . $this->user_handle;
    }

    public function getProfileimage()
    {
        return $this->hasOne(Image::className(), ['id' => 'profile_image']);
    }

    public function getCoverimage()
    {
        return $this->hasOne(Image::className(), ['id' => 'cover_image']);
    }


    public static function SocialColumnName($name)
    {
        return $name . '_source_id';
    }
    public function getActiveBloodReceiving()
    {
        return $this->hasMany(BloodReceiving::class, ['user_id' => 'id'])->where(['>=', 'requirement_date', date('Y-m-d')]);
    }
}
