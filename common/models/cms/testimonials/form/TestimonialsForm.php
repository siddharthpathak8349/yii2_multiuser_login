<?php
namespace common\models\cms\testimonials\form;
use common\models\cms\testimonials\Testimonials;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
/**
 * @property int $id
 * @property string $heading
 * @property string|null $author
 * @property int $sequence	
 * @property int|null $image
 * @property string|null $description
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class TestimonialsForm extends Testimonials
{
    public $id;
    public $heading;
    // public $hospital_name;
    public $author;
    public $image;
    public $description;
    // public $user_id;
    public $sequence;
    public $image_file;
    public $status;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $formModel;
    public $isNewRecord;
    public $image_file_remove;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => Testimonials::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->heading = $this->formModel->heading;
            // $this->hospital_name = $this->formModel->hospital_name;
            $this->author = $this->formModel->author;
            // $this->user_id = $this->formModel->user_id;
            $this->image = $this->formModel->image;
            $this->description = $this->formModel->description;
            $this->status = $this->formModel->status;
            $this->created_by = $this->formModel->created_by;
            $this->updated_by = $this->formModel->updated_by;
            $this->created_at = $this->formModel->created_at;
            $this->updated_at = $this->formModel->updated_at;
            $this->image_file = !empty($this->formModel->listingImage) ? $this->formModel->listingImage->url : NULL;
        }
    }

    public function rules()
    {
        return [
            [['heading'], 'required'],
            [['image', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'image_file', 'image_file_remove'], 'safe'],
            [['heading', 'author'], 'string', 'max' => 255],
            [['image_file'], 'file', 'extensions' => 'png, jpg, jpeg, svg', 'maxSize' => 1024 * 1000, 'tooBig' => 'Maximum size is 1 MB.', 'skipOnEmpty' => true],
            [['heading'], 'match', 'pattern' => '/^[A-Za-z0-9 ?\.]+$/', 'message' => 'Heading can only contain letters, numbers, spaces'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'heading' => 'Heading',
            // 'hospital_name' => 'Hospital Name',
            'author' => 'Author',
            // 'user_id' => 'User ID',
            'image' => 'Image',
            'description' => 'Description',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image_file' => 'Image File',
            'image_file_remove' => 'Remove Image File',
        ];
    }


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

    public function initializeForm()
    {
        $this->formModel->heading = $this->heading;
        // $this->formModel->hospital_name = $this->hospital_name;
        $this->formModel->author = $this->author;
        // $this->formModel->user_id = $this->user_id;
        $this->formModel->description = $this->description;
        $this->formModel->status = isset($this->status) ? $this->status : 1;
        $this->formModel->created_by = $this->created_by;
        $this->formModel->updated_by = $this->updated_by;
        $this->formModel->created_at = $this->created_at;
        $this->formModel->updated_at = $this->updated_at;
        if ($this->image_file_remove == true) {
            $this->formModel->image = NULL;
        } else {
            $this->formModel->image = $this->image;
        }
    } 

    public function UploadFiles()
    {

        if ($this->image_file) {
            $fullpath = '/cms/testimonials/' . strtolower(trim($this->heading)) . '/image';
            $title = $this->heading;
            $file = $this->image_file;
            $caption = $this->heading;
            $alt = $this->heading;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = Testimonials::findOne(['id' => $this->formModel->id]);
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
