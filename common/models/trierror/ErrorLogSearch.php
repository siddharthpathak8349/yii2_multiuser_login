<?php

namespace common\models\trierror;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\trierror\ErrorLog;

/**
 * ErrorLogSearch represents the model behind the search form of `common\models\ErrorLog`.
 */
class ErrorLogSearch extends ErrorLog
{

    /**
     * {@inheritdoc}
     */
    public $distinct;
    public function rules()
    {
        return [
            [['error_type', 'panel_type_id'], 'safe'],
            [['request_url', 'reference_url',], 'safe'],
            [['ip_address'], 'safe'],
            [['request_type'], 'safe'],
            [['distinct'], 'safe'],
            [['error_msg', 'reference_url', 'user_session_id'], 'safe']
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

        $query = ErrorLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (isset($this->distinct) && !empty($this->distinct)) {
            $query->groupBy(['request_url']);
            $query->select(['request_url', 'request_type', 'reference_url', 'error_type', 'ip_address', 'error_msg', 'source', 'user_session_id', 'created_at', 'id', 'COUNT(*) AS cnt']);
            $query->orderBy(['cnt' => SORT_DESC]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_session_id' => $this->user_session_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'request_url', $this->request_url])
            ->andFilterWhere(['like', 'request_type', $this->request_type])
            ->andFilterWhere(['like', 'reference_url', $this->reference_url])
            ->andFilterWhere(['like', 'panel_type_id', $this->panel_type_id])
            ->andFilterWhere(['like', 'error_type', $this->error_type])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'error_msg', $this->error_msg])
            ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }
}
