<?php
namespace common\models\master\occasion;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\occasion\MasterOccasion;

class MasterOccasionSearch extends MasterOccasion
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
        $query = MasterOccasion::find()->andWhere(['!=','status', SELF::STATUS_DELETED]);
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
