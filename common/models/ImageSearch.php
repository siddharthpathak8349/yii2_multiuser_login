<?php
namespace common\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ImageSearch extends Image
{
    public function rules()
    {
        return [
            [['id', 'bytesize', 'height', 'width', 'created_by', 'updated_by'], 'integer'],
            [['name', 'caption', 'alt', 'extension', 'filename', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $pagination = true)
    {
        $query = Image::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : [
                'defaultPageSize' => 10,
                'pageSizeLimit' => [10, 30],
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'bytesize' => $this->bytesize,
            'height' => $this->height,
            'width' => $this->width,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'caption', $this->caption])
            ->andFilterWhere(['like', 'alt', $this->alt])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'filename', $this->filename]);
        $count = $query->count();

        if ($count <= 10) {
            $dataProvider->pagination->pageSize = false;
        } else {
            $dataProvider->pagination->pageSize = 10;
        }
        return $dataProvider;
    }

}
