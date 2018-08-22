<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Markups;

/**
 * MarkupsSearch represents the model behind the search form of `backend\models\Markups`.
 */
class MarkupsSearch extends Markups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'from', 'to', 'value'], 'integer'],
            [['price_name', 'znak'], 'safe'],
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
        $query = Markups::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
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
            'from' => $this->from,
            'to' => $this->to,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'price_name', $this->price_name])
            ->andFilterWhere(['like', 'znak', $this->znak]);

        return $dataProvider;
    }
}
