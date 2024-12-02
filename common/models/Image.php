<?php
namespace common\models;
use Yii;
/**
 * @property int $id
 * @property string $name
 * @property string|null $caption
 * @property string|null $alt
 * @property string $extension meta_image_type_code
 * @property int|null $bytesize
 * @property int $height
 * @property int $width
 * @property string $filename
 * @property string $filepath
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by

 */
class Image extends \yii\db\ActiveRecord
{
    use \diecoding\flysystem\traits\ModelTrait;
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
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
            // 'slug' => [
            //     'class' => 'skeeks\yii2\slug\SlugBehavior',
            //     'slugAttribute' => 'alias', //The attribute to be generated
            //     'attribute' => 'name', //The attribute from which will be generated
            //     'maxLength' => 255,
            //     'minLength' => 3,
            //     'ensureUnique' => true,
            //     'slugifyOptions' => [
            //         'lowercase' => true,
            //         'separator' => '-',
            //         'trim' => true,
            //     ]
            // ]
        ];
    }
    
    public static function tableName()
    {
        return 'image';
    }

    public function rules()
    {
        return [
            [['name', 'extension', 'filename','filepath'], 'required'],
            [['caption','filepath'], 'string'],
            [['bytesize', 'height', 'width', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'alt', 'filename'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 10],
            // [['master_image_source_code'], 'string', 'max' => 3],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUrl()
    {
        // return \Yii::$app->fs->temporaryUrl($this->filepath, new \DateTimeImmutable('+1 Minutes'));
        // return \Yii::$app->fs->temporaryUrl('images/' . $this->id . '.' . strtolower($this->extension), new \DateTimeImmutable('+1 Minutes'));
        // return  \Yii::$app->fs->publicUrl('images/'.$this->id . '.' . strtolower($this->extension));
        return  \Yii::$app->fs->publicUrl($this->filepath);
    }

}
