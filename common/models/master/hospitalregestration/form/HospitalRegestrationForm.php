<?php
namespace common\models\master\hospitalregestration\form;
use common\models\master\hospitalregestration\HospitalRegestration;
use Yii;

class HospitalRegestrationForm extends HospitalRegestration
{
    public $id;
    public $name_of_hospital;
    public $profile;
    public $establish_date;
    public $profile_image_file;
    public $profile_image_file_remove;
    public $nat_blood_test_facility;
    public $thalamessia_patient_treatment;
    public $contact_person_name;
    public $employe_id;
    public $contact_number;
    public $contact_email;
    public $hod_name;
    public $hod_contact_number;
    public $hod_email;
    public $state;
    public $user_id;
    public $city;
    public $pincode;
    public $local_address;
    public $land_mark;
    public $status;
    public $formModel;
    public $isNewRecord;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => HospitalRegestration::className(),
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->id = $this->formModel->id;
            $this->name_of_hospital = $this->formModel->name_of_hospital;
            $this->profile = $this->formModel->profile;
            $this->nat_blood_test_facility = $this->formModel->nat_blood_test_facility;
            $this->thalamessia_patient_treatment = $this->formModel->thalamessia_patient_treatment;
            $this->contact_person_name = $this->formModel->contact_person_name;
            $this->employe_id = $this->formModel->employe_id;
            $this->contact_number = $this->formModel->contact_number;
            $this->contact_email = $this->formModel->contact_email;
            $this->hod_name = $this->formModel->hod_name;
            $this->hod_contact_number = $this->formModel->hod_contact_number;
            $this->hod_email = $this->formModel->hod_email;
            $this->state = $this->formModel->state;
            $this->city = $this->formModel->city;
            $this->pincode = $this->formModel->pincode;
            $this->user_id = $this->formModel->user_id;
            $this->local_address = $this->formModel->local_address;
            $this->land_mark = $this->formModel->land_mark;
            $this->status = $this->formModel->status;
            $this->establish_date = $this->formModel->establish_date;
            $this->profile_image_file = !empty($this->formModel->listingImage) ? $this->formModel->listingImage->url : NULL;
        }
    }

    public function rules()
    {
        return [
            [['name_of_hospital', 'contact_person_name', 'employe_id', 'nat_blood_test_facility', 'thalamessia_patient_treatment', 'hod_name', 'hod_email', 'local_address', 'contact_number', 'hod_contact_number', 'state', 'city', 'pincode', 'contact_email', 'status'], 'required'],
            [['name_of_hospital', 'contact_person_name', 'employe_id', 'contact_email', 'hod_name', 'hod_email', 'local_address', 'land_mark'], 'string', 'max' => 255],
            [['profile', 'nat_blood_test_facility', 'thalamessia_patient_treatment', 'contact_number', 'hod_contact_number', 'state', 'city', 'pincode', 'status', 'created_by', 'user_id', 'updated_by'], 'integer'],
            [['establish_date'], 'date', 'format' => 'php:Y-m-d'],

            [['created_at', 'updated_at'], 'safe'],
            [['contact_email', 'hod_email'], 'email'],
            [['contact_number', 'hod_contact_number'], 'match', 'pattern' => '/^[1-9]\d{9}$/', 'message' => 'Phone number must be exactly 10 digits long and cannot start with zero.'],
            [['profile_image_file', 'profile_image_file_remove', 'created_at', 'requirement_date', 'updated_at'], 'safe'],
            [['profile_image_file'], 'image', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 100, 'tooBig' => 'Maximum size is 100 KB.', 'skipOnEmpty' => true],
            [['name_of_hospital', 'contact_person_name', 'hod_name'], 'match', 'pattern' => '/^[A-Za-z0-9\s\/\-\.\@\(\)]+$/', 'message' => 'Name can only contain letters, numbers, spaces, slashes, dashes, dots, at signs, and parentheses.'],
            [['employe_id'], 'string', 'max' => 30],
            [['employe_id'], 'match', 'pattern' => '/^[A-Za-z0-9\-\/\@\#]+$/', 'message' => 'Employee ID can only contain letters, numbers, dashes, slashes, at signs, and hash signs.'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_of_hospital' => 'Name Of Hospital',
            'profile' => 'Profile',
            'nat_blood_test_facility' => 'NAT Blood Test Facility',
            'thalamessia_patient_treatment' => 'Thalassemia Patient Treatment',
            'contact_person_name' => 'Contact Person Name',
            'employe_id' => 'Employee ID',
            'contact_number' => 'Contact Number',
            'contact_email' => 'Contact Email',
            'hod_name' => 'HOD Name',
            'hod_contact_number' => 'HOD Contact Number',
            'hod_email' => 'HOD Email',
            'state' => 'State',
            'city' => 'City',
            'pincode' => 'Pincode',
            'local_address' => 'Local Address',
            'land_mark' => 'Landmark',
            'status' => 'Status',
            'user_id' => 'User',
            'establish_date' => 'Establishment Date',
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
            $this->formModel->save(false);
            return true;
        }
        return false;
    }


    public function initializeForm()
    {
        $this->formModel->name_of_hospital = $this->name_of_hospital;
        $this->formModel->profile = $this->profile;
        $this->formModel->nat_blood_test_facility = $this->nat_blood_test_facility;
        $this->formModel->thalamessia_patient_treatment = $this->thalamessia_patient_treatment;
        $this->formModel->contact_person_name = $this->contact_person_name;
        $this->formModel->employe_id = $this->employe_id;
        $this->formModel->contact_number = $this->contact_number;
        $this->formModel->contact_email = $this->contact_email;
        $this->formModel->hod_name = $this->hod_name;
        $this->formModel->hod_contact_number = $this->hod_contact_number;
        $this->formModel->hod_email = $this->hod_email;
        $this->formModel->state = $this->state;
        $this->formModel->city = $this->city;
        $this->formModel->establish_date = $this->establish_date;
        $this->formModel->pincode = $this->pincode;
        $this->formModel->local_address = $this->local_address;
        $this->formModel->land_mark = $this->land_mark;
        $this->formModel->status = $this->status;
        $this->formModel->user_id = $this->user_id;

        if ($this->profile_image_file_remove) {
            $this->formModel->profile = null;
        }
    }


    public function UploadFiles()
    {
        if ($this->profile_image_file) {
            $fullpath = '/raiserequest/bloodreceving/' . strtolower(trim($this->name_of_hospital)) . '/profile';
            $title = $this->name_of_hospital;
            $file = $this->profile_image_file;
            $caption = $this->name_of_hospital;
            $alt = $this->name_of_hospital;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = HospitalRegestration::findOne(['id' => $this->formModel->id]);
                $mtc->profile = $imageid;
                $mtc->save(false);
            }
        }

    }

    public function getImageFileUrl()
    {
        return $this->profile_image_file ? Yii::getAlias('@web') . '/' . $this->profile_image_file : null;
    }

}
