<?php
namespace common\models\cms\contentmanagement;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\contentmanagement\ContentManagement;

class ContentManagementSearch extends ContentManagement
{
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'updated_by', 'created_by'], 'integer'],
            [['name', 'type', 'content', 'remark'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ContentManagement::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
