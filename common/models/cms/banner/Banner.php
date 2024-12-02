<?php
namespace common\models\cms\banner;
use common\models\Image;
use common\traits\CommanRelationship;
use Yii;

/**
 * @property int $id
 * @property int|null $page_id
 * @property string|null $image
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Banner extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;
    public static function tableName()
    {
        return 'banner';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['page_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['page_id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function statusImage()
    {
        $text = NULL;
        $style = NULL;
        $width = "135px";
        $fontSize = "14px"; 

        switch ($this->status) {
            case self::STATUS_ACTIVE:
                $text = "Active";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            case self::STATUS_SUSPENDED:
                $text = "Suspend";
                $style = "border: 1px solid #f8d5db; border-radius: 20px; font-size: $fontSize; color: #da2f49; background-color: #f8d5db; width: $width;";
                break;
            case self::STATUS_DELETED:
                $text = "Deleted";
                $style = "border: 1px solid black; border-radius: 20px; font-size: $fontSize; color: black; background-color: #B3B3B3; width: $width;";
                break;
            default:
                return "";
        }

        if (!empty($text)) {
            return "<div style='display: inline-block; padding: 5px; text-align: center; $style'>$text</div>";
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
}
