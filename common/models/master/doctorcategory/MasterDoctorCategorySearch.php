<?php
namespace common\models\master\doctorcategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\doctorcategory\MasterDoctorCategory;

class MasterDoctorCategorySearch extends MasterDoctorCategory
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
        $query = MasterDoctorCategory::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
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