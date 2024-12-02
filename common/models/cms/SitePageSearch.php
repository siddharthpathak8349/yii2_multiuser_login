<?php
namespace common\models\cms;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\SitePage;

class SitePageSearch extends SitePage
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['meta_title', 'meta_keyword', 'meta_description', 'description', 'heading', 'slug', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SitePage::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keyword', $this->meta_keyword])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'heading', $this->heading])
            ->andFilterWhere(['like', 'slug', $this->slug]);
        return $dataProvider;
    }
}
