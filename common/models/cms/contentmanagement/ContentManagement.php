<?php
namespace common\models\cms\contentmanagement;
use common\traits\CommanRelationship;
use Yii;
/**
 * @property int $id
 * @property string $name
 * @property string $type P=>Page,B=>Block
 * @property string $content
 * @property string|null $remark
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $updated_by
 * @property int $created_by
 */
class ContentManagement extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;

    const CM_ABOUT = 1;
    const CM_TERM_AND_CONDITION = 2;
    const CM_BIRDING_TOUR_TERM_AND_CONDITION = 3;
    const CM_SAFARI_TERM_AND_CONDITION = 4;
    const CM_RESORT_TERM_AND_CONDITION = 5;
    const CM_DISCLAIMER = 6;
    const CM_ABOUT_US = 7;
    const CMS_PRIVACY_POLICY = 8;

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
                // 'value' => function () {
                //     return date('Y-m-d H:i:s');
                // },
            ],

        ];
    }
  
    public static function tableName()
    {
        return 'content_management';
    }

    public function rules()
    {
        return [
            [['id', 'name', 'type', 'content', 'created_at', 'updated_at', 'updated_by', 'created_by'], 'required'],
            [['id', 'created_at', 'updated_at', 'updated_by', 'status', 'created_by'], 'integer'],
            [['content'], 'string'],
            [['name', 'remark'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
            'remark' => 'Remark',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
        ];
    }

    public static function getTypeLabels()
    {
        return [
            'p' => 'Page',
            'b' => 'Block',
        ];
    }
}
