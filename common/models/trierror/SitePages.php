<?php

namespace common\models\trierror;

use Yii;

/**
 * This is the model class for table "site_pages".
 *
 * @property int $id
 * @property int $content_id
 * @property string|null $content_type
 * @property string|null $url
 * @property string|null $slug
 * @property string|null $last_update_at
 * @property int $exist_in_xml
 * @property string|null $xml_created_at
 * @property int $counter
 * @property int $status
 * @property string|null $updated_at
 * @property string|null $created_at
 * @property string|null $title
 * @property string|null $image
 * @property string|null $description
 * @property string|null $keywords
 */
class SitePages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id',  'counter', 'status'], 'integer'],
            [['last_update_at', 'updated_at', 'created_at'], 'safe'],
            [['url'], 'string', 'max' => 555],
            ['url', 'required'],
            ['url', 'filter', 'filter' => 'trim'],
            //['url', 'url_validation_creteria'],
            //[['url'], 'url'],
            //['url', 'match', 'pattern' => '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', 'message' => 'Enter custome valid url.'],
            [['slug'], 'string', 'max' => 255],
            [['title', 'description', 'keywords', 'image'], 'safe']
        ];
    }

    public function url_validation_creteria($model, $attribute)
    {
        if (isset($model->$attribute) and $model->$attribute != '') {
            /*echo "<pre>";
        print_r($model->url);
        echo "</pre>";
//        die($model->$attribute);
        print_r($attribute);
        die();
        */
            $this->addError($model, $attribute, 'inside loop');
        } else {
            $this->addError($model, $attribute, 'Invalid GST number');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'content_type' => 'Content Type',
            'url' => 'Url',
            'slug' => 'Slug',
            'last_update_at' => 'Last Update At',
            'counter' => 'Counter',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'title' => 'Title',
            'Keywords' => 'Keywords',
            'image' => 'Image',
            'description' => 'Description'
        ];
    }

    public function getImagepath()
    {
        if ($this->image != '') {
            return '/storage/ogtag_images/' . $this->id . '/' . $this->image;
        }
    }
}
