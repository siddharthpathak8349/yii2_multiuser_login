<?php

namespace common\models\trierror;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\trierror\SiteUntracedRequest;

/**
 * SearchSiteRobots represents the model behind the search form of `common\models\trierror\SiteUntracedRequest`.
 */
class SiteUntracedRequestSearch extends SiteUntracedRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['url'], 'safe'],
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
        $query = SiteUntracedRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orderBy('id', 'DESC');
        $query->andWhere(['status' => true]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
