<?php
namespace common\models\cms\banner\form;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\banner\Banner;

class BannerForm extends model
{
    public $page_id;
    public $image;
    public $image_file;
    public $image_file_remove;
    public $status;
    public $status_option = [];
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => Banner::className()
        ]);
        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->page_id = $this->formModel->page_id;
            $this->image = $this->formModel->image;
            $this->status = $this->formModel->status;
            $this->image_file = !empty($this->formModel->listingImage) ? $this->formModel->listingImage->url : NULL;
        }
    }

    public function rules()
    {
        return [
            [['page_id', 'image'], 'required', 'on' => 'create'],
            [['page_id'], 'required', 'on' => 'update'],
            [['status', 'image', 'page_id'], 'integer'],
            [['status'], 'default', 'value' => 1],
            [['created_at', 'updated_at', 'image_file', 'image_file_remove'], 'safe'],
            [['image_file'], 'file', 'extensions' => 'png, jpg, jpeg, svg', 'maxSize' => 1024 * 1000, 'tooBig' => 'Maximum size is 1 MB.', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'page_id' => 'Page',
            'image' => 'Banner Image',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->formModel->page_id = $this->page_id;
        $this->formModel->status = isset($this->status) ? $this->status : 1;
        if ($this->image_file_remove == true) {
            $this->formModel->image = NULL;
        } else {
            $this->formModel->image = $this->image;
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) {
            return true;
        }
        $this->initializeForm();
        if ($this->formModel->save()) {
            $this->UploadFiles();
            return true;
        }
        return false;
    }

    public function UploadFiles()
    {
        if ($this->image_file) {
            $fullpath = '/cms/banner/' . strtolower(trim($this->page_id)) . '/image';
            $title = $this->page_id;
            $file = $this->image_file;
            $caption = $this->page_id;
            $alt = $this->page_id;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = Banner::findOne(['id' => $this->formModel->id]);
                $mtc->image = $imageid;
                $mtc->save(false);
            }
        }
    }

    public function getImageFileUrl()
    {
        return $this->image_file ? Yii::getAlias('@web') . '/' . $this->image_file : null;
    }
}
