<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rendered_content".
 *
 * @property int $id
 * @property string $content
 * @property string|null $created_at
 */
class RenderedContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rendered_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'url', 'title', 'action_url', 'query_params'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
