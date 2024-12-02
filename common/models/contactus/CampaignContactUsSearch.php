<?php
namespace common\models\contactus;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CampaignContactUsSearch extends CampaignContactUs
{
    public function rules()
    {
        return [
            [['blood_group_id', 'model_id', 'user_id', 'age', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'address', 'name', 'phone','updated_at', 'email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CampaignContactUs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'blood_group_id' => $this->blood_group_id,
            'model_id' => $this->model_id,
            // 'name' => $this->name,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}