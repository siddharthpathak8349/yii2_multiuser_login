<?php
namespace common\models\raiserequest\checkeligibility;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BloodRecevingDonorEligibilityAnswerFromSearch extends BloodRecevingDonorEligibilityAnswer
{
    public function rules()
    {
        return [
            [['user_id', 'blood_receiving_id', 'hospital_id', 'eligibility_question_id', 'correct_answer', 'answer', 'status'], 'integer'],
            [['question', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BloodRecevingDonorEligibilityAnswer::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'blood_receiving_id' => $this->blood_receiving_id,
            'hospital_id' => $this->hospital_id,
            'eligibility_question_id' => $this->eligibility_question_id,
            'answer' => $this->answer,
            'correct_answer' => $this->correct_answer,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question]);


        return $dataProvider;
    }

    
}
