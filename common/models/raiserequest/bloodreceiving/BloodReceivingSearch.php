<?php
namespace common\models\raiserequest\bloodreceiving;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\raiserequest\bloodreceiving\BloodReceiving;

class BloodReceivingSearch extends BloodReceiving
{
    public $sort_order; 

    public function rules()
    {
        return [
            [['id', 'age', 'gender', 'patient_blood_group_id', 'hospital_id', 'units_needed', 'status', 'created_by', 'updated_by', 'is_verified'], 'integer'],
            [['patient_name', 'uhid_number', 'profession', 'patient_image', 'patient_id_proof', 'patient_disease_name', 'blood_component', 'requirement_date', 'hospital_demanding_letter', 'attendent_name', 'attendent_whatsapp_number', 'attendent_relation_with_patient', 'hospital_address', 'method_publishing_blood_request', 'created_at', 'sort_order', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BloodReceiving::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);


        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'age' => $this->age,
            'gender' => $this->gender,
            'patient_blood_group_id' => $this->patient_blood_group_id,
            'requirement_date' => $this->requirement_date,
            'hospital_id' => $this->hospital_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'units_needed' => $this->units_needed,
            // 'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_verified' => $this->is_verified,
        ]);


        if (!empty($this->created_at)) {
            $date = date('Y-m-d', strtotime($this->created_at));
            $query->andFilterWhere(['>=', 'created_at', $date . ' 00:00:00'])
                ->andFilterWhere(['<=', 'created_at', $date . ' 23:59:59']);
        }

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'uhid_number', $this->uhid_number])
            ->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'patient_image', $this->patient_image])
            ->andFilterWhere(['like', 'patient_id_proof', $this->patient_id_proof])
            ->andFilterWhere(['like', 'patient_disease_name', $this->patient_disease_name])
            ->andFilterWhere(['like', 'blood_component', $this->blood_component])
            ->andFilterWhere(['like', 'hospital_demanding_letter', $this->hospital_demanding_letter])
            ->andFilterWhere(['like', 'attendent_name', $this->attendent_name])
            ->andFilterWhere(['like', 'attendent_whatsapp_number', $this->attendent_whatsapp_number])
            ->andFilterWhere(['like', 'attendent_relation_with_patient', $this->attendent_relation_with_patient])
            ->andFilterWhere(['like', 'hospital_address', $this->hospital_address])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'method_publishing_blood_request', $this->method_publishing_blood_request]);
        return $dataProvider;
    }
}
