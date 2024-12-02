<?php
namespace common\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public $role_id;

    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'hospital_id', 'status'], 'integer'],
            [['username', 'email', 'password_hash'], 'string', 'max' => 255],
            [['name', 'role_id'], 'string', 'max' => 3],
            [['auth_key'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['profile_image', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find(); // Do not Show Adminstrator Role User

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]]
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'user.email' => $this->email,
            'password_hash' => $this->password_hash,
            'auth_key' => $this->auth_key,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
        ;
        return $dataProvider;
    }
}
