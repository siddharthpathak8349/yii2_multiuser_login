<?php
namespace common\models\cms;
use common\models\Image;
use Yii;
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
 * @property int|null $image
 * @property int|null $banner
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class SitePage extends \yii\db\ActiveRecord
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
        return 'static_page';
    }

    public function rules()
    {
        return [
            [['meta_title', 'heading'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'image', 'banner',], 'integer'],
            [['meta_title', 'meta_keyword', 'meta_description', 'heading', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
            'heading' => 'Heading',
            'slug' => 'Slug',
            'image' => 'Image',
            'banner' => 'Banner',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function statusImage()
    {
        $icon = NULL;
        $alt = NULL;
        if ($this->status == self::STATUS_ACTIVE) {
            $icon = "green-circle";
            $alt = "Enabled";
        } elseif ($this->status == self::STATUS_SUSPENDED) {
            $icon = "red-circle";
            $alt = "Pending";
        } elseif (self::STATUS_DELETED) {
            $icon = "grey-circle";
            $alt = "Disabled";
        }
        if (!empty($icon)) {

            return "<i class=" . $icon . " title='" . $alt . "'></i>";
        }
        return "";
    }

    public function getBannerImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'banner']);
    }

    public function getListingImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image']);
    }

    /**
     * @return string|null
     */
    public function getBannerImageUrl()
    {
        $bannerImage = $this->bannerImage;
        return $bannerImage ? $bannerImage->getUrl() : null;
    }

    /**
     * @return string|null
     */
    public function getListingImageUrl()
    {
        $listingImage = $this->listingImage;
        return $listingImage ? $listingImage->getUrl() : null;
    }

}
