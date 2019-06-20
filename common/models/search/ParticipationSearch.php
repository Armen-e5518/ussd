<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Participation;

/**
 * ParticipationSearch represents the model behind the search form of `common\models\Participation`.
 */
class ParticipationSearch extends Participation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uniteBase', 'flash', 'numParty', 'status', 'dateSession', 'session', 'bet_amount', 'party','drawing_id','account_id'], 'integer'],
            [['grille', 'date', 'numCollector', 'state', 'nature'], 'safe'],
            [['coeff'], 'number'],
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
        $query = Participation::find();

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
            'coeff' => $this->coeff,
            'uniteBase' => $this->uniteBase,
            'flash' => $this->flash,
            'numParty' => $this->numParty,
            'date' => $this->date,
            'status' => $this->status,
            'dateSession' => $this->dateSession,
            'session' => $this->session,
            'bet_amount' => $this->bet_amount,
            'party' => $this->party,
            'drawing_id' => $this->drawing_id,
            'account_id' => $this->account_id,
        ]);

        $query->andFilterWhere(['like', 'grille', $this->grille])
            ->andFilterWhere(['like', 'numCollector', $this->numCollector])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'nature', $this->nature]);

        return $dataProvider;
    }
}
