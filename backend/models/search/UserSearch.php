<?php

namespace backend\models\search;

use backend\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{
    const ADMIN_ID = 13;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'realm_id', 'role'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'recipient', 'avatar', 'access_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param array $role
     *
     * @return ActiveDataProvider
     */
    public function search($params, $role)
    {

        $query = User::find()
            ->andWhere(['<>', 'id', self::ADMIN_ID])
            ->orderBy(['id' => SORT_DESC]);

        if ($role == 'client') {
            $query->andWhere(['role' => User::ROLE_CLIENT]);
        }
        if ($role == 'manager') {
            $query->andWhere(['role' => User::ROLE_MANAGER]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'recipient', $this->recipient])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'realm_id', $this->realm_id]);

        return $dataProvider;
    }
}
