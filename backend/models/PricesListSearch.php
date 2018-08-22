<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PricesList;

/**
 * PricesListSearch represents the model behind the search form of `backend\models\PricesList`.
 */
class PricesListSearch extends PricesList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rows'], 'integer'],
            [['name', 'term', 'currency', 'date'], 'safe'],
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
        $query = PricesList::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
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
            'rows' => $this->rows,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'term', $this->term])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
