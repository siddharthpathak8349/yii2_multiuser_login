<?php
namespace common\models\cms\banner;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\banner\Banner;

class BannerSearch extends Banner
{
    public function rules()
    {
        return [
            [['page_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Banner::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'page_id', $this->page_id]);
        return $dataProvider;
    }
}
