<?php
namespace common\models\raiserequest\bloodrecevingdonor;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BloodRecevingDonorSearch extends BloodRecevingDonor
{
    public function rules()
    {
        return [
            [['user_id', 'blood_receving_id', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BloodRecevingDonor::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['like', 'blood_receving_id', $this->blood_receving_id]);
        return $dataProvider;
    }
}
