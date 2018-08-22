<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cart;

/**
 * CartSearch represents the model behind the search form of `backend\models\Cart`.
 */
class CartSearch extends Cart
{
    public $username;
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_count'], 'integer'],
            [['product_article', 'product_price_name', 'product_id', 'product_info', 'start_cart', 'ident'], 'safe'],
            
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
        $query = Cart::find();
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
            'carts.id' => $this->id,
            'carts.user_id' => $this->user_id,
            'carts.product_count' => $this->product_count,
//            'carts.start_cart' => $this->start_cart,
        ]);

        $query->andFilterWhere(['like', 'carts.product_article', $this->product_article])
            ->andFilterWhere(['like', 'carts.product_price_name', $this->product_price_name])
            ->andFilterWhere(['like', 'carts.product_id', $this->product_id])
            ->andFilterWhere(['like', 'carts.product_info', $this->product_info])
            ->andFilterWhere(['like', 'carts.ident', $this->ident])
            ->andFilterWhere(['like', 'carts.start_cart', $this->start_cart])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.name', $this->name]);

        return $dataProvider;
    }
}
