<?php
namespace common\models\cms\testimonials;
use common\models\Image;
use common\models\master\hospital\MasterHospital;
use Yii;
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
class Testimonials extends \yii\db\ActiveRecord
{
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
        ];
    }

    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;
   
    public static function tableName()
    {
        return 'testimonials';
    }

    public function rules()
    {
        return [
            [['heading'], 'required'],
            [['sequence', 'image', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['heading', 'author'], 'string', 'max' => 255],
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
            'sequence' => 'Sequence',
            'image' => 'Image',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function statusImage()
    {
        $icon = NULL;
        $alt = NULL;
        if ($this->status == self::STATUS_ACTIVE) {
            $icon = "green-circle";
            $alt = "Active";
        } elseif ($this->status == self::STATUS_SUSPENDED) {
            $icon = "red-circle";
            $alt = "Suspended";
        } elseif (self::STATUS_DELETED) {
            $icon = "grey-circle";
            $alt = "Deleted";
        }
        if (!empty($icon)) {

            return "<i class=" . $icon . " title='" . $alt . "'></i>";
        }
        return "";
    }

    public function getListingImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image']);
    }

    public function getListingImageUrl()
    {
        $listingImage = $this->listingImage;
        return $listingImage ? $listingImage->getUrl() : null;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $maxSequence = self::find()->max('sequence');
            $this->sequence = $maxSequence + 1;
        }
        return parent::beforeSave($insert);
    }

    // public function getHospital()
    // {
    //     return $this->hasOne(MasterHospital::className(), ['id' => 'hospital_name']);
    // }

}
