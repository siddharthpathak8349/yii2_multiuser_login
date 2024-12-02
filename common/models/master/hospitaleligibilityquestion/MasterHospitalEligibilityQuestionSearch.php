<?php
namespace common\models\master\hospitaleligibilityquestion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MasterHospitalEligibilityQuestionSearch extends MasterHospitalEligibilityQuestion
{


    public function rules()
    {
        return [
            [['hospital_id', 'category', 'answer', 'gender', 'status'], 'integer'],
            [['question'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MasterHospitalEligibilityQuestion::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'hospital_id' => $this->hospital_id,
            'category' => $this->category,
            'status' => $this->status,
            'answer' => $this->answer,
            'gender' => $this->gender,
        ]);
        $query->andFilterWhere(['like', 'question', $this->question]);

        return $dataProvider;
    }
}
