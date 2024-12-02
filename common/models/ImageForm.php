<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
/**
 * @property int $id
 * @property string $name
 * @property string $caption
 * @property string $alt
 * @property string|null $extension
 * @property int $bytesize
 * @property int $height
 * @property int $width
 * @property string|null $filename
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $created_at  
 * @property string|null $updated_at

 */
class ImageForm extends Image
{
    public $image;
    public $id;
    public $name;
    public $caption;
    public $alt;
    public $extension;
    public $bytesize;
    public $height;
    public $width;
    public $filename;
    public $formModel;
    public $isNewRecord;

    public function __construct($imageModel = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => Image::className()
        ]);

        $this->isNewRecord = true;
        if ($imageModel !== null) {
            $this->isNewRecord = false;
            $this->formModel = $imageModel;
            $this->id = $this->formModel->id;
            $this->name = $this->formModel->name;
            $this->caption = $this->formModel->caption;
            $this->alt = $this->formModel->alt;
            $this->extension = $this->formModel->extension;
            $this->bytesize = $this->formModel->bytesize;
            $this->height = $this->formModel->height;
            $this->width = $this->formModel->width;
            $this->filename = $this->formModel->filename;
        }
    }

    public function rules()
    {
        return [
            [['image', 'name'], 'required'],
            [['name', 'caption', 'alt'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 10],
            [['bytesize', 'height', 'width'], 'integer'],
            [['filename'], 'string'],
            [['caption', 'alt'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'svg'], 'maxSize' => 1024 * 1000, 'tooBig' => 'Maximum size is 1 MB.', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'caption' => 'Caption',
            'alt' => 'Alt',
            'extension' => 'Extension',
            'bytesize' => 'Bytesize',
            'height' => 'Height',
            'width' => 'Width',
            'filename' => 'Filename',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

        ];
    }

    public function UploadFiles()
    {
        if ($this->validate()) {
            if ($this->image) {
                $fullpath = '/images';
                $title = $this->name;
                $file = $this->image;
                $caption = $this->caption;
                $alt = $this->alt;
                $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
                if (!empty($imageid)) {

                    return true;
                }
            }
        }
        return false;
    }

    public function getImageFileUrl()
    {
        return $this->image ? Yii::getAlias('@web') . '/' . $this->image : null;
    }
}
