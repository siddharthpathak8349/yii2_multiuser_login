<?php
namespace common\models\meta\relation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\meta\relation\MetaRelation;

class MetaRelationSearch extends MetaRelation
{
    public function rules()
    {
        return [
            [['name', 'status'], 'safe'],
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
        $query = MetaRelation::find();
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
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
