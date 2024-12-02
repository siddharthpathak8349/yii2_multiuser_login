<?php

namespace common\models\trierror;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\trierror\FrontendRequestLog;

/**
 * FrontendRequestLogSearch represents the model behind the search form of `common\models\trierror\FrontendRequestLog`.
 */
class FrontendRequestLogSearch extends FrontendRequestLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'request_code', 'is_server_error', 'is_client_error', 'isAjax', 'is_count'], 'integer'],
            [['user_ip', 'slug', 'route', 'request_url', 'request_type', 'request_parameter', 'request_data', 'response_error', 'device', 'system', 'platform', 'browser', 'browser_version', 'created_at', 'request_group', 'is_count', 'is_reqeust_trace'], 'safe'],
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
        $query = FrontendRequestLog::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_server_error' => $this->is_server_error,
            'is_client_error' => $this->is_client_error,
            'isAjax' => $this->isAjax,
            'is_count' => $this->is_count,
            'created_at' => $this->created_at,
            'is_reqeust_trace' => $this->is_reqeust_trace,
        ]);

        if (!empty($this->request_code)) {
            $query->andFilterWhere(['like', 'request_code', $this->request_code]);
        }

        if (!empty($this->request_group)) {
            $query->andFilterWhere(['like', 'request_group', $this->request_group]);
        }

        $query->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'request_url', $this->request_url])
            ->andFilterWhere(['like', 'request_type', $this->request_type])
            ->andFilterWhere(['like', 'request_parameter', $this->request_parameter])
            ->andFilterWhere(['like', 'request_data', $this->request_data])
            ->andFilterWhere(['like', 'response_error', $this->response_error])
            ->andFilterWhere(['like', 'device', $this->device])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'browser_version', $this->browser_version]);

        return $dataProvider;
    }
}
