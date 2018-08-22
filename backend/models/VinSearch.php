<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Vin;

/**
 * VinSearch represents the model behind the search form of `backend\models\Vin`.
 */
class VinSearch extends Vin
{
    public $username;
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['user_contacts', 'vin', 'brand', 'model', 'year', 'engine', 'comment'], 'safe'],
            
            [['username', 'name'], 'safe']
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
        $query = Vin::find();
        $query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
        
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
            'label' => 'username'
        ];
        
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
            'label' => 'name'
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'vin.id' => $this->id,
            'vin.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'vin.user_contacts', $this->user_contacts])
            ->andFilterWhere(['like', 'vin.vin', $this->vin])
            ->andFilterWhere(['like', 'vin.brand', $this->brand])
            ->andFilterWhere(['like', 'vin.model', $this->model])
            ->andFilterWhere(['like', 'vin.year', $this->year])
            ->andFilterWhere(['like', 'vin.engine', $this->engine])
            ->andFilterWhere(['like', 'vin.comment', $this->comment])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.name', $this->name]);

        return $dataProvider;
    }
}
