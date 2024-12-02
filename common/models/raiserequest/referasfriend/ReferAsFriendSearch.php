<?php
namespace common\models\raiserequest\referasfriend;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReferAsFriendSearch extends ReferAsFriend
{
    public function rules()
    {
        return [
            [['id', 'phone', 'blood_group', 'state', 'city', 'created_by', 'updated_by', 'user_id', 'status'], 'integer'],
            [['name', 'location', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ReferAsFriend::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'phone' => $this->phone,
            'blood_group' => $this->blood_group,
            'state' => $this->state,
            'city' => $this->city,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
