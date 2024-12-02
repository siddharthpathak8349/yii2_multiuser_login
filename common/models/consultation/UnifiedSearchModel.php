<?php
namespace common\models\consultation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class UnifiedSearchModel extends Model
{
    public $name;
    public $type;
    public $status;

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['type'], 'in', 'range' => ['Counsellor', 'Dietician', 'Doctor']],
            [['status'], 'in', 'range' => [1, 0]],
        ];
    }

    public function search($params)
    {
        $this->load($params);

        $counsellorSearchModel = new CounsellorSearch();
        $dieticianSearchModel = new DieticianSearch();
        $doctorSearchModel = new DoctorSearch();

        $counsellorSearchModel->status = $this->status ?? Counsellor::STATUS_ACTIVE;
        $dieticianSearchModel->status = $this->status ?? Dietician::STATUS_ACTIVE;
        $doctorSearchModel->status = $this->status ?? Doctor::STATUS_ACTIVE;

        if (empty($this->type)) {
            $counsellorData = $counsellorSearchModel->search($params)->getModels();
            $dieticianData = $dieticianSearchModel->search($params)->getModels();
            $doctorData = $doctorSearchModel->search($params)->getModels();
        } else {
            $counsellorData = ($this->type === 'Counsellor') ? $counsellorSearchModel->search($params)->getModels() : [];
            $dieticianData = ($this->type === 'Dietician') ? $dieticianSearchModel->search($params)->getModels() : [];
            $doctorData = ($this->type === 'Doctor') ? $doctorSearchModel->search($params)->getModels() : [];
        }

        foreach ($counsellorData as &$counsellor) {
            $counsellor['type'] = 'Counsellor';
        }
        foreach ($dieticianData as &$dietician) {
            $dietician['type'] = 'Dietician';
        }
        foreach ($doctorData as &$doctor) {
            $doctor['type'] = 'Doctor';
        }

        $combinedData = array_merge($counsellorData, $dieticianData, $doctorData);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $combinedData,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['name', 'type', 'phone', 'inquiry', 'category', 'status'],
            ],
        ]);

        return $dataProvider;
    }



}