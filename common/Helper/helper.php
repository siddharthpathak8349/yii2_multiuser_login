<?php

namespace common\Helper;

use common\models\Campaign;
use common\models\cms\banner\Banner;
use common\models\cms\faq\Faq;
use common\models\cms\faq\FaqCategory;
use common\models\cms\testimonials\Testimonials;
use common\models\consultation\Counsellor;
use common\models\consultation\Dietician;
use common\models\consultation\Doctor;
use common\models\master\counsellorcategory\MasterCounsellorCategory;
use common\models\master\dieticiancategory\MasterDieticianCategory;
use common\models\master\doctorcategory\MasterDoctorCategory;
use common\models\master\hospital\MasterHospital;
use common\models\master\hospitaleligibilityquestioncategory\MasterHospitalEligibilityQuestionCategory;
use common\models\master\hospitalregestration\HospitalRegestration;
use common\models\master\MasterCity;
use common\models\master\MasterState;
use common\models\master\occasion\MasterOccasion;
use common\models\meta\bloodcomponents\MetaBloodComponents;
use common\models\meta\bloodgroup\MetaBloodGroup;
use common\models\meta\donortype\MetaDonorType;
use common\models\meta\method\MetaPublishingBloodRequestMethod;
use common\models\meta\relation\MetaRelation;
use common\models\raiserequest\bloodreceiving\BloodReceiving;
use common\models\raiserequest\donatingblood\DonatingBlood;
use common\models\User;
use common\models\Utm;
use Jenssegers\Agent\Agent;
use yii\helpers\Html;

class helper
{

    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 0;
    const STATUS_DELETED = -1;

    public static function MasterRelations()
    {
        $model = MetaRelation::find()->where(['status' => MetaRelation::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function MasterHospitals()
    {
        $model = HospitalRegestration::find()->where(['status' => HospitalRegestration::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name_of_hospital');
    }



    public static function MasterOccassion()
    {
        $model = MasterOccasion::find()->where(['status' => MasterOccasion::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function DonatingBloodStatus()
    {
        return [
            DonatingBlood::STATUS_ACTIVE => 'Accept',
            DonatingBlood::STATUS_SUSPENDED => 'Reject',
        ];
    }

    public static function MetaBloodGroup()
    {
        $model = MetaBloodGroup::find()->where(['status' => MetaBloodGroup::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function getBloodGroupName($bloodGroupId)
    {
        // Fetch the blood group record using the ID
        $bloodGroup = MetaBloodGroup::findOne($bloodGroupId);

        // Return the name if found, otherwise null
        return $bloodGroup ? $bloodGroup->name : null; // Adjust 'name' if the attribute is different
    }

    public static function MetaBloodComponent()
    {
        $model = MetaBloodComponents::find()->where(['status' => MetaBloodComponents::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'blood_component');
    }
    public static function MetaDonorType()
    {
        $model = MetaDonorType::find()->where(['status' => MetaDonorType::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function MetaPublishingBloodRequestMethod()
    {
        $model = MetaPublishingBloodRequestMethod::find()->where(['status' => MetaPublishingBloodRequestMethod::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function RecevingBloodStatus()
    {
        return [
                // BloodReceiving::STATUS_DELETED => 'Deleted',
            BloodReceiving::STATUS_SUSPENDED => 'Unfulfilled',
            BloodReceiving::STATUS_RAISE_REQUEST => 'Raise Request',
            BloodReceiving::STATUS_VERIFY => 'Verify',
            BloodReceiving::STATUS_LIVE_REQUEST => 'Live Request',
            BloodReceiving::STATUS_SMPC => 'SMPC',
            BloodReceiving::STATUS_CAMPAGIN_COST => 'Campaign Cost',
            BloodReceiving::STATUS_GENERATE_OTP_PER_UNIT => 'Generate OTP',
            BloodReceiving::STATUS_GET_DONOR_LIVE_LOCATION => 'Donor Live Location',
            BloodReceiving::STATUS_GET_CAMPAIGN_ANALYTICS => 'campaign analytics',
            BloodReceiving::STATUS_GET_DONOR_CONFIRMATION => 'donor confirmation',
            BloodReceiving::STATUS_SHARE_OTP_WITH_DONOR => 'Share OTP with Donor',
            BloodReceiving::STATUS_FULLFILLED => 'Fulfilled',
        ];
    }

    public static function BannerStatus()
    {
        return [
            Banner::STATUS_ACTIVE => 'Active',
            Banner::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function FaqStatus()
    {
        return [
            Faq::STATUS_ACTIVE => 'Enabled',
            Faq::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function TestimonialStatus()
    {
        return [
            Testimonials::STATUS_ACTIVE => 'Active',
            Testimonials::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function CounsellorStatus()
    {
        return [
            Counsellor::STATUS_ACTIVE => 'Active',
            Counsellor::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function RelationStatus()
    {
        return [
            MetaRelation::STATUS_ACTIVE => 'Active',
            MetaRelation::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function PublishingBloodRequestMethodStatus()
    {
        return [
            MetaPublishingBloodRequestMethod::STATUS_ACTIVE => 'Active',
            MetaPublishingBloodRequestMethod::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function DieticianStatus()
    {
        return [
            Dietician::STATUS_ACTIVE => 'Active',
            Dietician::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function DoctorStatus()
    {
        return [
            Doctor::STATUS_ACTIVE => 'Active',
            Doctor::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function FaqCategoryStatus()
    {
        return [
            FaqCategory::STATUS_ACTIVE => 'Active',
            FaqCategory::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function HospitalStatus()
    {
        return [
            MasterHospital::STATUS_ACTIVE => 'Active',
            MasterHospital::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function MasterOccassionStatus()
    {
        return [
            MasterOccasion::STATUS_ACTIVE => 'Active',
            MasterOccasion::STATUS_SUSPENDED => 'Suspend'
        ];
    }

    public static function getCounsellorCategoryOptions()
    {
        $categories = MasterCounsellorCategory::find()
            ->where(['status' => MasterCounsellorCategory::STATUS_ACTIVE])
            ->all();
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }
        return $categoryOptions;
    }

    public static function getDieticianCategoryOptions()
    {
        $categories = MasterDieticianCategory::find()
            ->where(['status' => MasterDieticianCategory::STATUS_ACTIVE])
            ->all();
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }
        return $categoryOptions;
    }

    public static function getDoctorCategoryOptions()
    {
        $categories = MasterDoctorCategory::find()
            ->where(['status' => MasterDoctorCategory::STATUS_ACTIVE])
            ->all();
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }
        return $categoryOptions;
    }

    public static function getGenderName($genderCode)
    {
        $genders = [
            1 => 'Male',
            2 => 'Female',
            3 => 'Other',
        ];

        return $genders[$genderCode] ?? 'Unknown';
    }

    public static function getHospitalDetails($hospitalId)
    {
        $hospital = HospitalRegestration::findOne($hospitalId);

        if ($hospital) {
            $state = MasterState::findOne($hospital->state);
            $stateName = $state ? Html::encode($state->state_name) : 'No state data present';

            $city = MasterCity::findOne($hospital->city);
            $cityName = $city ? Html::encode($city->city_name) : 'No city data present';

            return [
                'state' => $stateName,
                'city' => $cityName,
            ];
        }

        return [
            'state' => 'No state data present',
            'city' => 'No city data present',
        ];
    }


    public static function getStatusLabel($status)
    {
        $text = NULL;
        $style = NULL;
        $width = "135px";
        $fontSize = "14px";

        switch ($status) {
            case self::STATUS_ACTIVE:
                $text = "Approve";
                $style = "border: 1px solid #cce7d3; font-size: $fontSize; border-radius: 20px; color: #028824; background-color: #cce7d3; width: $width;";
                break;
            case self::STATUS_SUSPENDED:
                $text = "Not Approve";
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

    public static function MasterEligibilityQuestionCategory()
    {
        $model = MasterHospitalEligibilityQuestionCategory::find()->where(['status' => MasterHospitalEligibilityQuestionCategory::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    public static function MasterHospital()
    {
        $model = HospitalRegestration::find()->where(['status' => HospitalRegestration::STATUS_ACTIVE])->all();
        return \yii\helpers\ArrayHelper::map($model, 'id', 'name_of_hospital');
    }

    public static function storeUtm($campaignId, $request)
    {
        $agent = new Agent();

        $utms_array = $request->getQueryParams();

        $model = new Utm();
        $model->campaign_id = $campaignId;
        $model->utm_source = isset($utms_array['utm_source']) ? $utms_array['utm_source'] : null;
        $model->utm_medium = isset($utms_array['utm_medium']) ? $utms_array['utm_medium'] : null;
        $model->utm_campaign = isset($utms_array['utm_campaign']) ? $utms_array['utm_campaign'] : null;
        $model->utm_id = isset($utms_array['utm_id']) ? $utms_array['utm_id'] : null;
        $model->utm_term = isset($utms_array['utm_term']) ? $utms_array['utm_term'] : null;
        $model->utm_content = isset($utms_array['utm_content']) ? $utms_array['utm_content'] : null;

        $model->referer = $request->referrer;
        $model->ip_address = $request->userIP;
        $model->session_id = \Yii::$app->session->id;

        $model->device = $agent->device();
        $model->platform = $agent->platform();
        $model->platform_version = $agent->version($model->platform);
        $model->browser = $agent->browser();
        $model->browser_version = $agent->version($model->browser);
        $model->isRobot = $agent->isRobot();
        $model->robot = $agent->robot();

        return $model->save(false);

        // return $model->id;  
    }

    public static function getCampaignName($campaign_id)
    {
        $campaign = Campaign::findOne($campaign_id);
        return $campaign ? $campaign->title : null;
    }

    public static function getHospitalsName($hospital_id)
    {
        $hospital = HospitalRegestration::findOne(['id' => $hospital_id, 'status' => HospitalRegestration::STATUS_ACTIVE]);
        return $hospital ? $hospital->name_of_hospital : '(not set)';
    }

    public static function getUsername($donorId)
    {
        $user = User::findOne($donorId);
        return $user ? $user->username : 'No data present';
    }

    public static function getPatientName($bloodReceivingId)
    {
        if (!empty($bloodReceivingId)) {
            $bloodReceiving = BloodReceiving::findOne($bloodReceivingId);

            if ($bloodReceiving) {
                return $bloodReceiving->patient_name;
            }
        }
        return 'No data present';
    }

}
