<?php
namespace common\models\meta\bloodcomponents;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MetaBloodComponentsSearch extends MetaBloodComponents
{

    public function rules()
    {
        return [
            [['blood_component', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MetaBloodComponents::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'blood_component' => $this->blood_component,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'blood_component', $this->blood_component]);
        return $dataProvider;
    }
}
