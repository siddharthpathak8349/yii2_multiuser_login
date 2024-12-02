<?php
namespace common\models\cms\testimonials;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TestimonialsSearch extends Testimonials
{
    public function rules()
    {
        return [
            [['id', 'image', 'status', 'sequence', 'created_by', 'updated_by'], 'integer'],
            [['heading', 'author', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }
   
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $pagination = true)
    {
        $query = Testimonials::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sequence' => SORT_ASC,
                ],
            ],
            'pagination' => $pagination === false ? false : [
                'defaultPageSize' => 10,
                'pageSizeLimit' => [10, 30]
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {

            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            // 'hospital_name' => $this->hospital_name,
            'sequence' => $this->sequence,
            'image' => $this->image,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['like', 'heading', $this->heading])
            ->andFilterWhere(['like', 'author', $this->author])
            // ->andFilterWhere(['like', 'hospital_name', $this->hospital_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
