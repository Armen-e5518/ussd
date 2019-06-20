<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GameResults;

/**
 * GameResultsSearch represents the model behind the search form of `common\models\GameResults`.
 */
class GameResultsSearch extends GameResults
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'timeleft', 'timeleft2draw', 'timeleft2lbet', 'party', 'drawing_id', 'next_drawing_id', 'next_drawing_day_id', 'time', 'duration', 'timePassing', 'open'], 'integer'],
            [['step', 'return', 'results', 'playlistRun'], 'safe'],
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
        $query = GameResults::find();

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
            'timeleft' => $this->timeleft,
            'timeleft2draw' => $this->timeleft2draw,
            'timeleft2lbet' => $this->timeleft2lbet,
            'party' => $this->party,
            'drawing_id' => $this->drawing_id,
            'next_drawing_id' => $this->next_drawing_id,
            'next_drawing_day_id' => $this->next_drawing_day_id,
            'time' => $this->time,
            'duration' => $this->duration,
            'timePassing' => $this->timePassing,
            'open' => $this->open,
        ]);

        $query->andFilterWhere(['like', 'step', $this->step])
            ->andFilterWhere(['like', 'return', $this->return])
            ->andFilterWhere(['like', 'results', $this->results])
            ->andFilterWhere(['like', 'playlistRun', $this->playlistRun]);

        return $dataProvider;
    }
}
