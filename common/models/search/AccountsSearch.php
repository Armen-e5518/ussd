<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Accounts;

/**
 * AccountsSearch represents the model behind the search form of `common\models\Accounts`.
 */
class AccountsSearch extends Accounts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'secret_number'], 'integer'],
            [['pin_code', 'login_token', 'create_at'], 'safe'],
            [['balance'], 'number'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Accounts::find();

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
            'secret_number' => $this->secret_number,
            'balance' => $this->balance,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'pin_code', $this->pin_code])
            ->andFilterWhere(['like', 'login_token', $this->login_token]);

        return $dataProvider;
    }
}
