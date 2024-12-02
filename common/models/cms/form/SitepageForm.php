<?php
namespace common\models\cms\form;
use Yii;
use yii\base\Model;
use common\models\cms\SitePage;

/**
 * @property int $id
 * @property string $meta_title
 * @property string|null $meta_keyword
 * @property string|null $meta_description
 * @property string|null $description
 * @property string $heading
 * @property string $slug
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $banner
 * @property int $image
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class SitepageForm extends Model
{
    public $id;
    public $meta_title;
    public $meta_keyword;
    public $meta_description;
    public $description;
    public $heading;
    public $slug;
    public $banner;
    public $banner_file;
    public $image;
    public $image_file;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $status;
    public $formModel;
    public $isNewRecord;
    public $banner_file_remove;
    public $image_file_remove;

    public function __construct($model = null)
    {
        parent::__construct();
        $this->formModel = Yii::createObject([
            'class' => SitePage::className()
        ]);

        $this->isNewRecord = true;
        if ($model !== null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->meta_title = $this->formModel->meta_title;
            $this->meta_keyword = $this->formModel->meta_keyword;
            $this->meta_description = $this->formModel->meta_description;
            $this->description = $this->formModel->description;
            $this->heading = $this->formModel->heading;
            $this->banner = $this->formModel->banner;
            $this->image = $this->formModel->image;
            $this->slug = $this->formModel->slug;
            $this->status = $this->formModel->status;
            $this->banner_file = !empty($this->formModel->bannerImage) ? $this->formModel->bannerImage->url : NULL;
            $this->image_file = !empty($this->formModel->listingImage) ? $this->formModel->listingImage->url : NULL;
        } else {
            $this->status = SitePage::STATUS_ACTIVE;
        }
    }

    public function rules()
    {
        return [
            [['meta_title', 'heading'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'banner_file', 'image_file', 'banner_file_remove', 'image_file_remove'], 'safe'],
            [['created_by', 'updated_by', 'status', 'banner', 'image',], 'integer'],
            [['meta_title', 'meta_keyword', 'meta_description', 'heading', 'slug'], 'string', 'max' => 255],
            [
                ['slug'],
                'unique',
                'targetClass' => SitePage::className(),
                'filter' => function ($query) {
                    if (!$this->isNewRecord) {
                        $query->andWhere(['<>', 'id', $this->id]);
                    }
                }
            ],
            [['banner_file', 'image_file'], 'file', 'extensions' => 'png, jpg, jpeg, svg', 'maxSize' => 1024 * 1000, 'tooBig' => 'Maximum size is 1 MB.', 'skipOnEmpty' => true],

        ];
    }

    public function attributeLabels()
    {
        return [
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
            'heading' => 'Heading',
            'slug' => 'Slug',
            'banner' => 'Banner',
            'image' => 'Image',
            'status' => 'Status',
        ];
    }

    /**
     * @param bool $runValidation 
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        $this->initializeForm();
        if ($this->formModel->save()) {
            $this->UploadFiles();
            return true;
        }
        return false;
    }

    protected function initializeForm()
    {
        $this->formModel->meta_title = $this->meta_title;
        $this->formModel->meta_keyword = $this->meta_keyword;
        $this->formModel->meta_description = $this->meta_description;
        $this->formModel->description = $this->description;
        $this->formModel->heading = $this->heading;
        $this->formModel->banner = $this->banner;
        $this->formModel->image = $this->image;
        $this->formModel->status = true;
        if ($this->banner_file_remove == true) {
            $this->formModel->banner = NULL;
        }
        if ($this->image_file_remove == true) {
            $this->formModel->image = NULL;
        }
    }

    public function UploadFiles()
    {
        if ($this->banner_file) {
            $fullpath = '/cms/sitepage/' . strtolower(trim($this->meta_title)) . '/banner';
            $title = $this->meta_title;
            $file = $this->banner_file;
            $caption = $this->meta_title;
            $alt = $this->meta_title;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);

            if (!empty($imageid)) {
                $mtc = SitePage::findOne(['id' => $this->formModel->id]);
                $mtc->banner = $imageid;
                $mtc->save(false);
            }
        }

        if ($this->image_file) {
            $fullpath = '/cms/sitepage/' . strtolower(trim($this->meta_title)) . '/image';
            $title = $this->meta_title;
            $file = $this->image_file;
            $caption = $this->meta_title;
            $alt = $this->meta_title;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);

            if (!empty($imageid)) {
                $mtc = SitePage::findOne(['id' => $this->formModel->id]);
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
