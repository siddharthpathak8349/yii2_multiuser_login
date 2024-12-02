<?php
namespace common\models\meta\donortype;
use common\models\meta\donortype\MetaDonorType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MetaDonorTypeSearch extends MetaDonorType
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

    public function search($params)
    {
        $query = MetaDonorType::find();
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
