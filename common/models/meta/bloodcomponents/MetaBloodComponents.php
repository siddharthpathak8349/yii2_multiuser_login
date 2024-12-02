<?php
namespace common\models\meta\bloodcomponents;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MetaBloodComponents extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1; //Deleted
    const STATUS_SUSPENDED = 0;  // Suspend
    const STATUS_ACTIVE = 1;   // Active

    public static function tableName()
    {
        return 'meta_blood_components';
    }

    public function rules()
    {
        return [
            [['blood_component'], 'required'],
            [['status'], 'integer'],
            [['blood_component'], 'string', 'max' => 40],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blood_component' => 'Blood Component',
            'status' => 'Status',
        ];
    }
}