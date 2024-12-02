<?php
namespace common\models\raiserequest\bloodreceiving;
use common\models\Image;
use common\models\meta\bloodgroup\MetaBloodGroup;
use Yii;
/**
 * @property int $id
 * @property string|null $patient_name
 * @property string|null $uhid_number
 * @property int|null $age
 * @property string|null $gender
 * @property string|null $profession
 * @property string|null $patient_image
 * @property string|null $slug
 * @property string|null $patient_id_proof
 * @property string|null $patient_disease_name
 * @property int|null $patient_blood_group_id
 * @property string|null $blood_component
 * @property string|null $description
 * @property string|null $requirement_date
 * @property string|null $hospital_demanding_letter
 * @property string|null $attendent_name
 * @property int|null $attendent_whatsapp_number
 * @property string|null $attendent_relation_with_patient 
 * @property int|null $hospital_id
 * @property int|null $user_id
 * @property string|null $hospital_address
 * @property string|null $method_publishing_blood_request
 * @property int|null $status
 * @property int|null $smpc_status
 * @property int|null $days_of_health_issue 
 * @property int|null $period
 * @property int|null $units_needed
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_patient_kyc_document
 * @property int $is_patient_uhid
 * @property int $is_hospital_demanding_letter
 * @property int $is_patient_deasise_name
 * @property int $is_pateint_requirement_date
 */
class BloodReceiving extends \yii\db\ActiveRecord
{
    const TOTAL_UNITS = 10;

    // for gender
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    //status
    const STATUS_DELETED = -1; //deleted
    const STATUS_SUSPENDED = 0;  // unfullfilled
    const STATUS_RAISE_REQUEST = 1;   //  RAISE REQIEST
    const STATUS_VERIFY = 2;   // VERIFY
    const STATUS_LIVE_REQUEST = 3;   // LIVE REQUEST
    const STATUS_SMPC = 4;   // SMPC
    const STATUS_CAMPAGIN_COST = 5;   // CAMPAGIN COST
    const STATUS_GENERATE_OTP_PER_UNIT = 6;   // GENERATE OTP
    const STATUS_GET_DONOR_LIVE_LOCATION = 7;   // DONOR LIVE LOCATION
    const STATUS_GET_CAMPAIGN_ANALYTICS = 8;
    const STATUS_GET_DONOR_CONFIRMATION = 9;
    const STATUS_SHARE_OTP_WITH_DONOR = 10;   // SARE OTP WITH DONOR
    const STATUS_FULLFILLED = 11;   // fullfilled

    public static function tableName()
    {
        return 'blood_receiving';
    }

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

    public function rules()
    {
        return [
            [['age', 'is_pateint_requirement_date', 'is_patient_deasise_name', 'is_hospital_demanding_letter', 'is_patient_uhid', 'is_patient_kyc_document', 'patient_blood_group_id', 'notified_donor', 'total_viewer', 'units_needed', 'attendent_whatsapp_number', 'days_of_health_issue', 'hospital_id', 'user_id', 'status', 'smpc_status', 'created_by', 'updated_by', 'gender'], 'integer'],
            [['requirement_date', 'created_at', 'updated_at'], 'safe'],
            [['patient_name', 'uhid_number', 'profession', 'patient_disease_name', 'blood_component', 'attendent_name', 'attendent_relation_with_patient', 'hospital_address', 'method_publishing_blood_request'], 'string', 'max' => 255],
            [['description', 'period'], 'string'],
            [['units_donated', 'units_remain'], 'integer', 'max' => 10],
            [['slug'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_patient_kyc_document' => 'Is Patient KYC Document',
            'is_patient_uhid' => 'Is Patient UHID',
            'is_hospital_demanding_letter' => 'Is Hospital Demanding Letter',
            'is_patient_deasise_name' => 'Is Patient Disease Name',
            'is_pateint_requirement_date' => 'Is Patient Requirement Date',
            'patient_name' => 'Name',
            'uhid_number' => 'UHID Number',
            'age' => 'Age',
            'period' => 'Periods',
            'gender' => 'Gender',
            'profession' => 'Profession',
            'patient_image' => 'Patient Photo',
            'patient_id_proof' => ' Id Proof of Patient',
            'patient_disease_name' => 'Patient Disease Name',
            'patient_blood_group_id' => ' Blood Group of Patient',
            'blood_component' => 'Blood Component',
            'requirement_date' => ' Date of Requirement',
            'hospital_demanding_letter' => 'Hospital Demanding Letter',
            'attendent_name' => 'Name',
            'user_id' => 'User',
            'slug' => 'Slug',
            'days_of_health_issue' => 'How Many Days Of Health Issue ?',
            'description' => 'Description',
            'notified_donor' => 'Notified Donor',
            'total_viewer' => 'Total Viewer',
            'units_needed' => 'Units Needed',
            'units_donated' => 'Units Donated',
            'units_remain' => 'Units Remain',
            'attendent_whatsapp_number' => 'WhatsApp Number',
            'attendent_relation_with_patient' => 'Your Relation With the Patient',
            'hospital_id' => 'Hospital Name',
            'hospital_address' => 'Hospital Address',
            'method_publishing_blood_request' => ' Choose Method of Publishing Blood Request',
        ];
    }

    public function statusImage()
    {
        $text = NULL;
        $style = NULL;
        $width = "auto";
        $fontSize = "14px";

        switch ($this->status) {
            case self::STATUS_DELETED:
                $text = "DELETED";
                $style = "border: 1px solid black; border-radius: 20px; font-size: $fontSize; color: black; background-color: #B3B3B3; width: $width;";
                break;
            case self::STATUS_SUSPENDED:
                $text = "UNFULLFILLED";
                $style = "border: 1px solid #f8d5db; border-radius: 20px; font-size: $fontSize; color: #da2f49; background-color: #f8d5db; width: $width;";
                break;
            case self::STATUS_RAISE_REQUEST:
                $text = "RAISE REQUEST";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_VERIFY:
                $text = "VERIFY";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_LIVE_REQUEST:
                $text = "LIVE REQUEST";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_SMPC:
                $text = "SMPC";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_CAMPAGIN_COST:
                $text = "CAMPAGIN COST";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_GENERATE_OTP_PER_UNIT:
                $text = "GENERATE OTP";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_GET_DONOR_LIVE_LOCATION:
                $text = "DONOR LIVE LOCATION";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_SHARE_OTP_WITH_DONOR:
                $text = "SHARE OTP WITH DONOR";
                $style = "border: 1px solid #65cade; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #65cade; width: $width;";
                break;
            case self::STATUS_FULLFILLED:
                $text = "FULLFILLED";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            default:
                return "";
        }

        if (!empty($text)) {
            return "<div  class='status-image' style='display: inline-block; padding: 5px; text-align: center; $style'>$text</div>";
        }
        return "";
    }

    public static function getGenderName($genderCode)
    {
        $genders = [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHER => 'Other',
        ];
        return $genders[$genderCode] ?? 'Unknown';
    }

    public static function getGenderOptions()
    {
        return [
            self::GENDER_MALE => self::getGenderName(self::GENDER_MALE),
            self::GENDER_FEMALE => self::getGenderName(self::GENDER_FEMALE),
            self::GENDER_OTHER => self::getGenderName(self::GENDER_OTHER),
        ];
    }

    //  fetching image for pateitn image
    public function getPatientImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'patient_image']);
    }
    public function getListingImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'patient_image']);
    }

    public function getListingImagepaitent()
    {
        return $this->hasOne(Image::className(), ['id' => 'patient_image']);
    }

    public function getListingImageUrl()
    {
        $ListingImagepaitent = $this->ListingImagepaitent;
        return $ListingImagepaitent ? $ListingImagepaitent->getUrl() : null;
    }

    //  fetching IDproof for pateitn image
    public function getIdproofImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'patient_id_proof']);
    }
    public function getListingImageidproof()
    {
        return $this->hasOne(Image::className(), ['id' => 'patient_id_proof']);
    }

    public function getListingImageUrlidproof()
    {
        $listingImageidproof = $this->listingImageidproof;
        return $listingImageidproof ? $listingImageidproof->getUrl() : null;
    }

    //  fetching hospital letter or doc or image  of pateint
    public function getHospitalletterImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'hospital_demanding_letter']);
    }
    public function getListingImageletter()
    {
        return $this->hasOne(Image::className(), ['id' => 'hospital_demanding_letter']);
    }

    public function getListingImageUrlletter()
    {
        $listingImageletter = $this->listingImageletter;
        return $listingImageletter ? $listingImageletter->getUrl() : null;
    }

    public function getRaisedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);

    }

    public function getBloodGroup()
    {
        return $this->hasOne(MetaBloodGroup::class, ['id' => 'patient_blood_group_id']);
    }
}
