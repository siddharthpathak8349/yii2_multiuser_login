<?php
namespace common\models;
use common\models\ContactForm;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ContactFormSearch extends ContactForm
{
  
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'user_id'], 'integer'],
            [['name', 'message', 'user_ip_address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 215],
            [['phone'], 'string', 'max' => 10],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version'], 'safe'],
            [['user_agent'], 'string', 'max' => 512],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $pagination = true)
    {
        $query = ContactForm::find()->where(['status' => [1, 2]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
