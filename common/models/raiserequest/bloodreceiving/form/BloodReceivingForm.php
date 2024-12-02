<?php
namespace common\models\raiserequest\bloodreceiving\form;
use common\models\raiserequest\bloodreceiving\BloodReceiving;
use Yii;
use yii\base\Model;

class BloodReceivingForm extends BloodReceiving
{
    public $id;
    public $patient_name;
    public $uhid_number;
    public $age;
    public $slug;
    public $gender;
    public $profession;
    public $patient_image;
    public $patient_image_file;
    public $patient_image_file_url;
    public $patient_id_proof;
    public $patient_id_proof_file;
    public $patient_id_proof_file_url;
    public $hospital_demanding_letter;
    public $hospital_demanding_letter_file;
    public $hospital_demanding_letter_file_url;
    public $patient_disease_name;
    public $patient_blood_group_id;
    public $blood_component;
    public $requirement_date;
    public $attendent_name;
    public $attendent_whatsapp_number;
    public $attendent_relation_with_patient;
    public $hospital_id;
    public $hospital_address;
    public $method_publishing_blood_request;
    public $status;
    public $smpc_status = 0;
    public $user_id;
    public $is_patient_kyc_document;
    public $is_patient_uhid;
    public $is_hospital_demanding_letter;
    public $is_patient_deasise_name;
    public $is_pateint_requirement_date;
    public $formModel;
    public $isNewRecord;
    public $patient_image_file_remove;
    public $patient_id_proof_file_remove;
    public $hospital_demanding_letter_file_remove;
    public $description;
    public $notified_donor;
    public $total_viewer;
    public $units_needed;
    public $units_donated;
    public $units_remain;
    public $days_of_health_issue;
    public $period;

    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => BloodReceiving::className()
        ]);

        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->patient_name = $this->formModel->patient_name;
            $this->uhid_number = $this->formModel->uhid_number;
            $this->period = $this->formModel->period;
            $this->age = $this->formModel->age;
            $this->days_of_health_issue = $this->formModel->days_of_health_issue;
            $this->gender = $this->formModel->gender;
            $this->profession = $this->formModel->profession;
            $this->patient_image = $this->formModel->patient_image;
            $this->patient_id_proof = $this->formModel->patient_id_proof;
            $this->patient_disease_name = $this->formModel->patient_disease_name;
            $this->patient_blood_group_id = $this->formModel->patient_blood_group_id;
            $this->blood_component = $this->formModel->blood_component;
            $this->requirement_date = $this->formModel->requirement_date;
            $this->hospital_demanding_letter = $this->formModel->hospital_demanding_letter;
            $this->attendent_name = $this->formModel->attendent_name;
            $this->attendent_whatsapp_number = $this->formModel->attendent_whatsapp_number;
            $this->attendent_relation_with_patient = $this->formModel->attendent_relation_with_patient;
            $this->hospital_id = $this->formModel->hospital_id;
            $this->hospital_address = $this->formModel->hospital_address;
            $this->method_publishing_blood_request = $this->formModel->method_publishing_blood_request;
            $this->description = $this->formModel->description;
            $this->notified_donor = $this->formModel->notified_donor;
            $this->total_viewer = $this->formModel->total_viewer;
            $this->units_needed = $this->formModel->units_needed;
            $this->units_donated = $this->formModel->units_donated;
            $this->units_remain = $this->formModel->units_remain;
            $this->user_id = $this->formModel->user_id;
            $this->status = $this->formModel->status;
            $this->smpc_status = $this->formModel->smpc_status;

            $this->is_patient_kyc_document = $this->formModel->is_patient_kyc_document;
            $this->is_patient_uhid = $this->formModel->is_patient_uhid;
            $this->is_hospital_demanding_letter = $this->formModel->is_hospital_demanding_letter;
            $this->is_patient_deasise_name = $this->formModel->is_patient_deasise_name;
            $this->is_pateint_requirement_date = $this->formModel->is_pateint_requirement_date;

            $this->patient_image_file_url = !empty($this->formModel->patientImage) ? $this->formModel->patientImage->url : NULL;
            $this->patient_id_proof_file_url = !empty($this->formModel->idproofImage) ? $this->formModel->idproofImage->url : NULL;
            $this->hospital_demanding_letter_file_url = !empty($this->formModel->hospitalletterImage) ? $this->formModel->hospitalletterImage->url : NULL;
        }
    }

    public function rules()
    {
        return [
            [['age', 'uhid_number', 'patient_name', 'gender', 'profession', 'patient_disease_name', 'requirement_date', 'patient_blood_group_id', 'attendent_name', 'attendent_whatsapp_number', 'hospital_id', 'attendent_relation_with_patient', 'method_publishing_blood_request', 'blood_component'], 'required'],
            [['patient_image', 'is_pateint_requirement_date', 'is_patient_deasise_name', 'is_hospital_demanding_letter', 'is_patient_uhid', 'is_patient_kyc_document', 'patient_id_proof', 'hospital_demanding_letter', 'age', 'patient_blood_group_id', 'units_needed', 'attendent_whatsapp_number', 'updated_by', 'days_of_health_issue', 'notified_donor', 'hospital_id', 'user_id', 'status', 'smpc_status'], 'integer'],
            [['patient_image_file_remove', 'total_viewer', 'patient_id_proof_file_remove', 'hospital_demanding_letter_file_remove', 'created_at', 'created_by', 'requirement_date', 'updated_at', 'updated_by'], 'safe'],

            // [
            //     ['patient_image_file'],
            //     'required',
            //     'when' => function ($model) {
            //         return $model->isNewRecord;
            //     },
            //     'message' => 'Please upload a patient image.'
            // ],




            // [
            //     ['patient_image_file'],
            //     'required',
            //     'when' => function ($model) {
            //         return $model->isNewRecord && $model->scenario === 'create';
            //     },
            //     'message' => 'Please upload a patient image.',
            //     'on'=>'create'
            // ],




            [
                ['patient_image_file'],
                'image',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024 * 100,
                'minWidth' => 250,
                'maxWidth' => 250,
                'minHeight' => 250,
                'maxHeight' => 250,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => true,
                'on' => 'update'

            ],

            [
                ['patient_image_file'],
                'image',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024 * 100,
                'minWidth' => 250,
                'maxWidth' => 250,
                'minHeight' => 250,
                'maxHeight' => 250,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => false,
                'on' => 'create'

            ],

            [
                ['patient_id_proof_file'],
                'file',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024 * 100,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => true,
                'on' => 'update'
            ],
            [
                ['patient_id_proof_file'],
                'file',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024 * 100,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => false,
                'on' => 'create'
            ],

            [
                ['hospital_demanding_letter_file'],
                'file',
                'extensions' => 'png, jpg, jpeg, pdf, doc, docx',
                'maxSize' => 1024 * 100,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => true,
                'on' => 'update'
            ],
            [
                ['hospital_demanding_letter_file'],
                'file',
                'extensions' => 'png, jpg, jpeg, pdf, doc, docx',
                'maxSize' => 1024 * 100,
                'tooBig' => 'Maximum size is 100 KB.',
                'skipOnEmpty' => false,
                'on' => 'create'
            ],

            // [
            //     ['patient_id_proof_file'],
            //     'required',
            //     'when' => function ($model) {
            //         return $model->isNewRecord;
            //     },
            //     'message' => 'Please upload a patient ID proof file.'
            // ],


            // [
            //     ['hospital_demanding_letter_file'],
            //     'required',
            //     'when' => function ($model) {
            //         return $model->isNewRecord;
            //     },
            //     'message' => 'Please upload a hospital demanding letter file.'
            // ],
            [
                ['days_of_health_issue'],
                'required',
                'when' => function ($model) {
                    return $model->isNewRecord;
                },
                'message' => 'Required'
            ],
            [
                ['period'],
                'required',
                'when' => function ($model) {
                    return $model->isNewRecord;
                },
                'message' => 'Required'
            ],



            // [['patient_image_file'], 'image', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 100, 'minWidth' => 250, 'maxWidth' => 250, 'minHeight' => 250, 'maxHeight' => 250, 'tooBig' => 'Maximum size is 100 KB.', 'skipOnEmpty' => true],
            // [['patient_id_proof_file'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 100, 'tooBig' => 'Maximum size is 100 KB.', 'skipOnEmpty' => true],
            // [['hospital_demanding_letter_file'], 'file', 'extensions' => 'png, jpg, jpeg, pdf, doc, docx', 'maxSize' => 1024 * 100, 'tooBig' => 'Maximum size is 100 KB.', 'skipOnEmpty' => true],
            // [['hospital_demanding_letter_file'], 'file', 'extensions' => 'png, jpg, jpeg, pdf, doc, docx', 'maxSize' => 1024 * 100, 'tooBig' => 'Maximum size is 100 KB.', 'skipOnEmpty' => true],
            [['patient_name', 'profession', 'patient_disease_name', 'blood_component', 'attendent_name', 'attendent_relation_with_patient', 'hospital_address', 'method_publishing_blood_request'], 'string', 'max' => 255],
            [['gender'], 'integer', 'max' => 5],
            [['uhid_number'], 'string', 'max' => 14],
            [['slug'], 'string', 'max' => 100],
            [['description', 'period'], 'string'],
            ['uhid_number', 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'The field can only contain letters, numbers'],
            [['age'], 'integer', 'min' => 0, 'max' => 150],
            [['patient_name'], 'match', 'pattern' => '/^[A-Za-z ]+$/', 'message' => 'Patient name can only contain letters and spaces.'],
            [['attendent_whatsapp_number'], 'string', 'min' => 10, 'max' => 10, 'message' => 'Should be 10 digit long.'],
            [['attendent_whatsapp_number', 'units_needed'], \common\validators\NoZeroPhoneNumberValidator::class],
            [['status', 'smpc_status'], 'integer'],
            [['units_needed'], 'integer', 'min' => 1, 'max' => 10, 'message' => 'Number of units required must be between 1 and 10.'],
            [['patient_disease_name', 'attendent_name'], 'match', 'pattern' => '/^[A-Za-z ]+$/', 'message' => 'The field can only contain letters'],
            [['units_donated', 'units_remain'], 'integer', 'max' => 10],
            ['total_viewer', 'integer', 'max' => 99999999999999999, 'message' => 'Value is out of range.'],
            ['notified_donor', 'integer', 'max' => 99999999999999999, 'message' => 'Value is out of range.'],
            [['units_donated'], 'compare', 'compareAttribute' => 'units_needed', 'operator' => '<=', 'message' => 'Units donated cannot exceed units needed.'],
            [
                ['is_pateint_requirement_date', 'is_patient_deasise_name', 'is_hospital_demanding_letter', 'is_patient_uhid', 'is_patient_kyc_document', 'units_donated'],
                'required',
                'when' => function ($model) {
                    return !$model->isNewRecord;
                },
                'whenClient' => "function (attribute, value) {
                return $('#model-id').val() !== ''; // Adjust the selector accordingly
            }"
            ],

            [
                ['units_needed'],
                'required',
                'when' => function ($model) {
                    return $model->isNewRecord;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#model-id').val() === ''; // Adjust the selector accordingly
                }",
                'message' => 'Units needed is required '
            ],
            [['days_of_health_issue'], 'integer', 'min' => 0, 'max' => 10000, 'message' => 'Please enter a value between 1 and 10,000.'],

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
            'days_of_health_issue' => 'How Many Days Of Health Issue ?',
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

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['patient_name', 'days_of_health_issue', 'period', 'uhid_number', 'age', 'gender', 'units_needed', 'profession', 'patient_image_file', 'patient_id_proof_file', 'patient_disease_name', 'patient_blood_group_id', 'blood_component', 'requirement_date', 'hospital_demanding_letter_file', 'attendent_name', 'attendent_whatsapp_number', 'attendent_relation_with_patient', 'hospital_id', 'hospital_address', 'method_publishing_blood_request', 'status'];
        $scenarios['update'] = ['units_remain', 'is_pateint_requirement_date', 'is_patient_deasise_name', 'is_hospital_demanding_letter', 'is_patient_uhid', 'is_patient_kyc_document', 'units_donated', 'units_needed', 'patient_image_file', 'patient_id_proof_file', 'total_viewer', 'patient_image_file_remove', 'patient_id_proof_file_remove', 'description', 'notified_donor', 'hospital_demanding_letter_file', 'hospital_demanding_letter_file_remove', 'uhid_number', 'age', 'gender', 'profession', 'patient_disease_name', 'patient_blood_group_id', 'blood_component', 'requirement_date', 'attendent_name', 'attendent_whatsapp_number', 'attendent_relation_with_patient', 'hospital_id', 'hospital_address', 'method_publishing_blood_request', 'status'];
        return $scenarios;
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
        $this->formModel->patient_name = $this->patient_name;
        $this->formModel->uhid_number = $this->uhid_number;
        $this->formModel->age = $this->age;
        $this->formModel->gender = $this->gender;
        $this->formModel->profession = $this->profession;
        $this->formModel->patient_image = $this->patient_image;
        $this->formModel->patient_id_proof = $this->patient_id_proof;
        $this->formModel->patient_disease_name = $this->patient_disease_name;
        $this->formModel->patient_blood_group_id = $this->patient_blood_group_id;
        $this->formModel->blood_component = $this->blood_component;
        $this->formModel->requirement_date = $this->requirement_date;
        $this->formModel->hospital_demanding_letter = $this->hospital_demanding_letter;
        $this->formModel->attendent_name = $this->attendent_name;
        $this->formModel->attendent_whatsapp_number = $this->attendent_whatsapp_number;
        $this->formModel->attendent_relation_with_patient = $this->attendent_relation_with_patient;
        $this->formModel->hospital_id = $this->hospital_id;
        $this->formModel->hospital_address = $this->hospital_address;
        $this->formModel->method_publishing_blood_request = $this->method_publishing_blood_request;
        $this->formModel->status = $this->status;
        $this->formModel->smpc_status = $this->smpc_status;
        $this->formModel->notified_donor = $this->notified_donor;
        $this->formModel->description = $this->description;
        $this->formModel->total_viewer = $this->total_viewer;
        $this->formModel->units_needed = $this->units_needed;
        $this->formModel->units_donated = $this->units_donated;
        $this->formModel->units_remain = $this->units_remain;
        $this->formModel->user_id = $this->user_id;
        $this->formModel->slug = $this->slug;
        $this->formModel->period = $this->period;
        $this->formModel->days_of_health_issue = $this->days_of_health_issue;
        $this->formModel->is_patient_kyc_document = $this->is_patient_kyc_document;
        $this->formModel->is_patient_uhid = $this->is_patient_uhid;
        $this->formModel->is_hospital_demanding_letter = $this->is_hospital_demanding_letter;
        $this->formModel->is_patient_deasise_name = $this->is_patient_deasise_name;
        $this->formModel->is_pateint_requirement_date = $this->is_pateint_requirement_date;

        if ($this->patient_image_file_remove) {
            $this->formModel->patient_image = null;
        }
        if ($this->patient_id_proof_file_remove) {
            $this->formModel->patient_id_proof = null;
        }
        if ($this->hospital_demanding_letter_file_remove) {
            $this->formModel->hospital_demanding_letter = null;
        }
    }

    public function UploadFiles()
    {
        if ($this->patient_image_file) {
            $fullpath = '/raiserequest/bloodreceving/' . strtolower(trim($this->patient_name)) . '/patient_image';
            $title = $this->patient_name;
            $file = $this->patient_image_file;
            $caption = $this->patient_name;
            $alt = $this->patient_name;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = BloodReceiving::findOne(['id' => $this->formModel->id]);
                $mtc->patient_image = $imageid;
                $mtc->save(false);
            }
        }

        if ($this->patient_id_proof_file) {
            $fullpath = '/raiserequest/bloodreceving/' . strtolower(trim($this->patient_name)) . '/patient_id_proof';
            $title = $this->patient_name;
            $file = $this->patient_id_proof_file;
            $caption = $this->patient_name;
            $alt = $this->patient_name;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = BloodReceiving::findOne(['id' => $this->formModel->id]);
                $mtc->patient_id_proof = $imageid;
                $mtc->save(false);
            }
        }

        if ($this->hospital_demanding_letter_file) {
            $fullpath = '/raiserequest/bloodreceving/' . strtolower(trim($this->patient_name)) . '/hospital_demanding_letter';
            $title = $this->patient_name;
            $file = $this->hospital_demanding_letter_file;
            $caption = $this->patient_name;
            $alt = $this->patient_name;
            $imageid = \common\utility\FsHelper::UploadFile($file, $fullpath, $title, $caption, $alt);
            if (!empty($imageid)) {
                $mtc = BloodReceiving::findOne(['id' => $this->formModel->id]);
                $mtc->hospital_demanding_letter = $imageid;
                $mtc->save(false);
            }
        }
    }

    public function getImageFileUrl()
    {
        return $this->patient_image_file ? Yii::getAlias('@web') . '/' . $this->patient_image_file : null;
    }

}
