<?php

namespace common\models\trierror\form;

use Yii;
use yii\base\Model;
use common\models\trierror;
use common\models\trierror\FrontendErrorLog;
use common\models\trierror\SitePages;

/**
 * This is the model class for table "ErrorLog".
 *
 * @property int $id
 * @property string|null $error_report
 * @property string|null $request_url
 * @property string|null $reference_url
 * @property string|null $ip_address
 * @property string|null $request_type
 * @property string|null $error_msg
 */
class SitePagesForm extends Model
{

    /**
     * {@inheritdoc}
     */
    public $id;
    public $title;
    public $description;
    public $keywords;
    public $image;
    public $site_pages_seo;

    public function __construct($model = null)
    {
        $this->site_pages_seo = $model;
        $this->title = $this->site_pages_seo->title;
        $this->description = $this->site_pages_seo->description;
        $this->keywords = $this->site_pages_seo->keywords;
        $this->image = $this->site_pages_seo->image;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'keywords'], 'required'],
            [['image'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title'            => 'Title',
            'keywords'           => 'Keywords',
            'description'         => 'Description',
            'image'            => 'Image',
        ];
    }

    public function initializeForm()
    {
        $this->site_pages_seo->title = $this->title;
        $this->site_pages_seo->keywords = $this->keywords;
        $this->site_pages_seo->description = $this->description;
    }

    public function uploadFile()
    {
        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/ogtag_images';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->site_pages_seo->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'ogtag_images_' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($this->image->saveAs($filePath)) {
                $fileName = "storage/ogtag_images" . "/" . $this->site_pages_seo->id . "/" . $fileName;
                $this->site_pages_seo->image = $fileName;
                $this->site_pages_seo->save(false);
            }
        }
    }
}
