<?php
namespace common\models\meta\donortype;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MetaDonorType extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1; //Deleted
    const STATUS_SUSPENDED = 0;  // Suspend
    const STATUS_ACTIVE = 1;   // Active

    public static function tableName()
    {
        return 'meta_donor_type';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Donor Type',
            'status' => 'Status',
        ];
    }
}