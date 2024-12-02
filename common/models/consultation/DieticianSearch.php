<?php
namespace common\models\consultation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DieticianSearch extends Dietician
{
    public function rules()
    {
        return [
            [['id', 'ddl_blood_seva_id', 'phone', 'inquiry', 'category', 'status'], 'integer'],
            [['name', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    //  public function search($params)
    //  {
    //      $query = Dietician::find();
    //      $dataProvider = new ActiveDataProvider([
    //          'query' => $query,
    //      ]);
    //      $this->load($params);
    //      if (!$this->validate()) {
    //          return $dataProvider;
    //      }
    //      $query->andFilterWhere([
    //          'id' => $this->id,
    //          'ddl_blood_seva_id' => $this->ddl_blood_seva_id,
    //          'phone' => $this->phone,
    //          'inquiry' => $this->inquiry,
    //          'category' => $this->category,
    //          'status' => $this->status,
    //          'type' => $this->type,
    //          'created_at' => $this->created_at,
    //          'updated_at' => $this->updated_at,
    //          'created_by' => $this->created_by,
    //          'updated_by' => $this->updated_by,
    //      ]);

    //      $query->andFilterWhere(['like', 'name', $this->name]);
    //      $query->andFilterWhere(['like', 'type', $this->type]);
    //      $query->andFilterWhere(['like', 'ddl_blood_seva_id', $this->ddl_blood_seva_id]);
    //      $query->andFilterWhere(['like', 'phone', $this->phone]);
    //      $query->andFilterWhere(['like', 'category', $this->category]);
    //      return $dataProvider;
    //  }
    public function search($params)
    {
        $query = Dietician::find();
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['status' => $this->status]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}