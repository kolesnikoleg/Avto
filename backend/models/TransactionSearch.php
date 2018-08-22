<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `backend\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $username;
    public $name;
    
    public $createdFrom;
    public $createdTo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'order_id'], 'integer'],
            [['math_op', 'value', 'date', 'admin_comment', 'comment_for_user'], 'safe'],
            
            [['username', 'name', 'createdTo', 'createdFrom', 'admin'], 'safe'],
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
        $query = Transaction::find();
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
            'transaction.id' => $this->id,
            'transaction.user_id' => $this->user_id,
            'transaction.order_id' => $this->order_id,
        ]);

        $query->andFilterWhere(['like', 'transaction.math_op', $this->math_op])
            ->andFilterWhere(['like', 'transaction.value', $this->value])
            ->andFilterWhere(['like', 'transaction.date', $this->date])
            ->andFilterWhere(['like', 'transaction.admin_comment', $this->admin_comment])
            ->andFilterWhere(['like', 'transaction.comment_for_user', $this->comment_for_user])
            ->andFilterWhere(['like', 'transaction.admin', $this->admin])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.name', $this->name])
            ->andFilterWhere(['>=', 'transaction.date', $this->createdFrom])
            ->andFilterWhere(['<=', 'transaction.date', $this->createdTo]);

        return $dataProvider;
    }
}
