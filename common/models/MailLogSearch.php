<?php

namespace common\models;

use common\models\MailLog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MailLogSearch represents the model behind the search form of `common\models\MailLog`.
 */
class MailLogSearch extends MailLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail_template_id', 'try_send_count', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['params'], 'string'],
            [['mail_send_time'], 'safe'],
            [['subject', 'aws_message_id'], 'string', 'max' => 255],
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
        $query = MailLog::find()->where(['status' => [1, 2]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],

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
            'mail_template_id' => $this->mail_template_id,
            'subject' => $this->subject,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
