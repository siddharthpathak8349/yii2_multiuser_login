<?php

namespace common\models;
use yii\base\Model;
use \common\models\User;

/**
 * UserForm model
 *
 * @property string $password_hash
 * @property string $password 
 */
class ResetpasswordForm extends Model
{

    /**
     * {@inheritdoc}
     */
    public $password;
    public $confirmpassword;
    public $chnagepasswordform;
    public $action_url;
    public $action_validate_url;


    public function __construct(User $model = null)
    {
        $this->chnagepasswordform = \Yii::createObject([
            'class' => User::className()
        ]);
        if ($model != '') {
            $this->chnagepasswordform = $model;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'confirmpassword'], 'required'],
            ['password', 'string', 'min' => 4],
            ['confirmpassword', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'confirmpassword' => 'Repeat Password',
        ];
    }
}
