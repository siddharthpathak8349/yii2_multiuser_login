<?php

namespace common\models\notification;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\notification\FrontendNotification;

/**
 * FrontendNotificationearch represents the model behind the search form of `common\models\notification\FrontendNotification`.
 */
class FrontendNotificationSearch extends FrontendNotification
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_id', 'chat_id', 'sent_to_operator_id', 'status', 'is_seen', 'is_read', 'delay_time', 'user_id', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'safe'],
            [['seen_datetime', 'read_datetime'], 'safe'],
            [['notification_url', 'notification_text', 'sent_to_operator_name'], 'safe'],
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
    public function search($params, $pagination = 30)
    {
        $query = FrontendNotification::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 30 : $pagination],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'action_id'                             => $this->action_id,
            'sent_to_operator_id'                       => $this->sent_to_operator_id,
            'status'                                => $this->status,
            'is_seen'                               => $this->is_seen,
            'is_read'                               => $this->is_read,
            'user_id'                               => $this->user_id,
            'seen_datetime'                         => $this->seen_datetime,
            'read_datetime'                         => $this->read_datetime,
            'created_by'                            => $this->created_by,
            'created_at'                            => $this->created_at,
            'updated_at'                            => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'sent_to_operator_name', $this->sent_to_operator_name]);
        $query->andFilterWhere(['like', 'notification_text', $this->notification_text]);

        return $dataProvider;
    }
}
