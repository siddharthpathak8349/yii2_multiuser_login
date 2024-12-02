<?php
namespace common\models\master\dieticiancategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\dieticiancategory\MasterDieticianCategory;

class MasterDieticianCategorySearch extends MasterDieticianCategory
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
        $query = MasterDieticianCategory::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
