<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property int $id
 * @property int|null $category 1=>campaign,2=>blood receiving campaign
 * @property string|null $template_type
 * @property int|null $model_id
 * @property int|null $template_id
 * @property string|null $title
 * @property string|null $slug
 * @property int $status
 * @property int|null $parent_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Campaign extends \yii\db\ActiveRecord
{

    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    const CATEGORY_CAMPAIGN = 1;
    const CATEGORY_BLOOD_RECEIVING = 2;


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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'template_id', 'status', 'parent_id', 'created_by', 'updated_by', 'model_id'], 'integer'],
            [['model_id', 'created_at', 'updated_at', 'valid_till_datetime'], 'safe'],
            [['template_type', 'title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique', 'filter' => ['!=', 'id', $this->id]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'template_type' => 'Template Type',
            'model_id' => 'Model ID',
            'template_id' => 'Template ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'status' => 'Status',
            'valid_till_datetime' => 'Valid Till Datetime',
            'parent_id' => 'Parent ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            // 'deleted_by' => 'Deleted By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
