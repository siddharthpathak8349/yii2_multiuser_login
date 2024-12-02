<?php

namespace common\models\cms\faq;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\faq\Faq;

class FaqSearch extends Faq
{
    public function rules()
    {
        return [
            [['id', 'sequence', 'type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['master_faq_category_id', 'question', 'answer', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Faq::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'sequence' => $this->sequence,
            'type' => $this->type,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'master_faq_category_id', $this->master_faq_category_id])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'type', $this->type]);



        return $dataProvider;
    }
}
