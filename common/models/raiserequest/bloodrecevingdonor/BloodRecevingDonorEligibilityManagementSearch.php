<?php

namespace common\models\raiserequest\bloodrecevingdonor;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class BloodRecevingDonorEligibilityManagementSearch extends BloodRecevingDonorEligibilityManagement
{

    public $donor_name;
    public $donor_email;
    public $requirement_date_range;
    public $current_date;
    public $end_date;

    public function rules()
    {
        return [
            [['id', 'blood_receiving_id', 'donor_id', 'hospital_id', 'hospital_action_status', 'status', 'created_by', 'updated_by'], 'integer'],
            [['donor_name', 'donor_email', 'created_at', 'updated_at', 'requirement_date_range'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BloodRecevingDonorEligibilityManagement::find()->andWhere(['!=', 'status', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['blood_receiving_id' => $this->blood_receiving_id]);
        $query->andFilterWhere(['donor_id' => $this->donor_id]);
        $query->andFilterWhere(['hospital_id' => $this->hospital_id]);
        $query->andFilterWhere(['hospital_action_status' => $this->hospital_action_status]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['created_by' => $this->created_by]);
        $query->andFilterWhere(['updated_by' => $this->updated_by]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        $query->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }

    public function searchBackend($params, $uniqueRecords)
    {
        $this->load($params);

        if (!$this->validate()) {
            return new ArrayDataProvider([
                'allModels' => $uniqueRecords,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }

        if (!empty($this->requirement_date_range)) {
            list($start_date, $end_date) = explode(' to ', $this->requirement_date_range);
        } else {
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime('+10 days'));
        }

        $filteredRecords = array_filter($uniqueRecords, function ($record) use ($start_date, $end_date) {
            $requirementDateMatch = (
                $record->bloodReceiving->requirement_date >= $start_date &&
                $record->bloodReceiving->requirement_date <= $end_date
            );

            $hospitalActionStatusMatch =
                ($this->hospital_action_status === '' || $this->hospital_action_status === null)
                || $record->hospital_action_status === (int) $this->hospital_action_status;

            // Matching filters for donor name and donor email
            $donorNameMatch = !$this->donor_name || stripos($record->donor->name, $this->donor_name) !== false;
            $donorEmailMatch = !$this->donor_email || stripos($record->donor->email, $this->donor_email) !== false;

            $otherFiltersMatch =
                (!$this->id || $record->id == $this->id)
                && (!$this->blood_receiving_id || $record->blood_receiving_id == $this->blood_receiving_id)
                && (!$this->donor_id || $record->donor_id == $this->donor_id)
                && (!$this->hospital_id || $record->hospital_id == $this->hospital_id)
                && (!$this->status || $record->status == $this->status);

            return $requirementDateMatch && $hospitalActionStatusMatch && $otherFiltersMatch && $donorNameMatch && $donorEmailMatch;
        });

        return new ArrayDataProvider([
            'allModels' => $filteredRecords,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}
