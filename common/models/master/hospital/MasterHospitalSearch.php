<?php
namespace common\models\master\hospital;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\hospital\MasterHospital;

class MasterHospitalSearch extends MasterHospital
{
    public function rules()
    {
        return [
            [['name', 'bussiness_email_id', 'address', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MasterHospital::find()->andWhere(['!=', 'status', self::STATUS_DELETED]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'phone' => $this->phone,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'bussiness_email_id', $this->bussiness_email_id])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'country_id', $this->country_id])
            ->andFilterWhere(['like', 'state_id', $this->state_id])
            ->andFilterWhere(['like', 'city_id', $this->city_id]);

        return $dataProvider;
    }
}
