<?php
namespace common\models\meta\bloodgroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\meta\bloodgroup\MetaBloodGroup;

class MetaBloodGroupSearch extends MetaBloodGroup
{

    public function rules()
    {
        return [
            [['name', 'can_accept', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MetaBloodGroup::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'can_accept' => $this->can_accept,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
