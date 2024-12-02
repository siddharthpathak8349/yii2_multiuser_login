<?php
namespace common\models\master\hospitalregestration;

use common\models\Image;
use common\models\master\MasterCity;
use common\models\master\MasterState;

/**
 * @property int $id
 * @property string|null $name_of_hospital
 * @property int|null $establish_date
 * @property int|null $profile
 * @property int $nat_blood_test_facility
 * @property int $thalamessia_patient_treatment
 * @property string|null $contact_person_name
 * @property string|null $employe_id
 * @property int|null $contact_number
 * @property string|null $contact_email
 * @property string|null $hod_name
 * @property int|null $hod_contact_number
 * @property string|null $hod_email
 * @property int|null $state
 * @property int|null $city
 * @property int|null $pincode
 * @property string|null $local_address
 * @property string|null $land_mark
 * @property int|null $user_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class HospitalRegestration extends \yii\db\ActiveRecord
{
    //status
    const STATUS_DELETED = -1;
    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

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

    public static function tableName()
    {
        return 'hospital_regestration';
    }

    public function rules()
    {
        return [
            [['profile', 'nat_blood_test_facility',  'thalamessia_patient_treatment', 'contact_number', 'hod_contact_number', 'state', 'city', 'pincode', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['establish_date'], 'date', 'format' => 'php:Y-m-d'],

            [['name_of_hospital', 'contact_person_name', 'employe_id', 'contact_email', 'hod_name', 'hod_email', 'local_address', 'land_mark'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_of_hospital' => 'Name Of Hospital',
            'profile' => 'Profile',
            'nat_blood_test_facility' => 'Nat Blood Test Facility',
            'thalamessia_patient_treatment' => 'Thalamessia Patient Treatment',
            'contact_person_name' => 'Contact Person Name',
            'employe_id' => 'Employe ID',
            'contact_number' => 'Contact Number',
            'contact_email' => 'Contact Email',
            'hod_name' => 'Hod Name',
            'hod_contact_number' => 'Hod Contact Number',
            'hod_email' => 'Hod Email',
            'state' => 'State',
            'city' => 'City',
            'pincode' => 'Pincode',
            'local_address' => 'Local Address',
            'land_mark' => 'Land Mark',
            'user_id' => 'User ID', 
            'status' => 'Status',
            'establish_date' => 'Establishment Date',
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
        return $this->hasOne(Image::className(), ['id' => 'profile']);
    }

    public function getListingImageUrl()
    {
        $listingImage = $this->listingImage;
        return $listingImage ? $listingImage->getUrl() : null;
    }

    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state']);
    }

    public function getCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'city']);
    }


}
