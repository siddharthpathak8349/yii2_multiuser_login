<?php
namespace common\models\master\hospitalregestration;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HospitalRegestrationSearch extends HospitalRegestration
{
    public function rules()
    {
        return [
            [['id', 'profile', 'nat_blood_test_facility', 'thalamessia_patient_treatment', 'contact_number', 'hod_contact_number', 'state', 'city', 'pincode', 'user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name_of_hospital', 'contact_person_name', 'employe_id', 'contact_email', 'hod_name', 'hod_email', 'local_address', 'land_mark', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = HospitalRegestration::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'profile' => $this->profile,
            'nat_blood_test_facility' => $this->nat_blood_test_facility,
            'thalamessia_patient_treatment' => $this->thalamessia_patient_treatment,
            'contact_number' => $this->contact_number,
            'hod_contact_number' => $this->hod_contact_number,
            'state' => $this->state,
            'city' => $this->city,
            'pincode' => $this->pincode,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_of_hospital', $this->name_of_hospital])
            ->andFilterWhere(['like', 'contact_person_name', $this->contact_person_name])
            ->andFilterWhere(['like', 'employe_id', $this->employe_id])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'hod_name', $this->hod_name])
            ->andFilterWhere(['like', 'hod_email', $this->hod_email])
            ->andFilterWhere(['like', 'local_address', $this->local_address])
            ->andFilterWhere(['like', 'land_mark', $this->land_mark]);

        return $dataProvider;
    }
}
