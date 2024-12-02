<?php
namespace common\models\cms\faq;
use common\models\cms\faq\FaqCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FaqCategorySearch extends FaqCategory
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
        $query = FaqCategory::find()->andWhere(['!=','status', SELF::STATUS_DELETED]);
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
