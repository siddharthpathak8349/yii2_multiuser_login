<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RenderedContentSearch represents the model behind the search form of `common\models\RenderedContent`.
 */
class RenderedContentSearch extends RenderedContent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'url', 'title', 'action_url', 'query_params'], 'safe'],
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
    public function search($params, $pagination = true)
    {
        $query = RenderedContent::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],

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
            'url' => $this->url,
            'action_url' => $this->action_url,
            'created_at' => $this->created_at,
            'query_params' => $this->query_params,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
