<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form of `common\models\Campaign`.
 */
class CampaignSearch extends Campaign
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category', 'template_id', 'is_draft', 'status', 'parent_id', 'created_by', 'updated_by'], 'integer'],
            [['template_type', 'title', 'slug', 'created_at', 'updated_at', 'valid_till_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Campaign::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category' => $this->category,
            'model_id' => $this->model_id,
            'template_id' => $this->template_id,
            'is_draft' => $this->is_draft,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'valid_till_datetime' => $this->valid_till_datetime,
            // 'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'template_type', $this->template_type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
