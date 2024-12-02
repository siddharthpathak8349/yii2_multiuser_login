<?php

namespace common\models\trierror;

use Yii;

/**
 * This is the model class for table "site_untraced_request".
 *
 * @property int $id
 * @property string $url
 * @property int $status
 */
class SiteUntracedRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_untraced_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['status'], 'integer'],
            [['url'], 'string', 'max' => 555],
            ['url', 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'status' => 'Status',
        ];
    }
}
