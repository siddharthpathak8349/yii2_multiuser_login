<?php
namespace common\models\raiserequest\donatingblood;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DonatingBloodSearch extends DonatingBlood
{

    public function rules()
    {
        return [
            [['id', 'ddl_blood_seva_id', 'phone', 'hospital_id', 'occasion_id', 'status'], 'integer'],
            [['name', 'date_of_donation', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DonatingBlood::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'ddl_blood_seva_id' => $this->ddl_blood_seva_id,
            'phone' => $this->phone,
            'hospital_id' => $this->hospital_id,
            'date_of_donation' => $this->date_of_donation,
            'occasion_id' => $this->occasion_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}