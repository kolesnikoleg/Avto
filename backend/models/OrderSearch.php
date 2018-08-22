<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;
use yii\db\Query;

/**
 * OrderSearch represents the model behind the search form of `backend\models\Order`.
 */
class OrderSearch extends Order
{
    public $username;
    public $name;
    
    public $adm_status;
    
    public $createdFrom;
    public $createdTo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'date_status', 'date_admin_comment', 'admin_archive', 'user_archive', 'date_changed', 'user_delete'], 'integer'],
            [['products', 'date', 'dostavka', 'phone', 'status', 'admin_status', 'client_comment', 'admin_comment', 'who_admin_comment', 'who_admin_changed'], 'safe'],
        
            [['username', 'name', 'adm_status', 'createdTo', 'createdFrom'], 'safe']
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
        $query = Order::find();
        $query->joinWith(['admin' => function($query){ $query->from(['adm' => 'admin']); }]);
        $query->joinWith(['user']);
//        $query->joinWith(['admin']);

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
        
        $dataProvider->sort->attributes['adm_status'] = [
            'asc' => ['adm.username' => SORT_ASC],
            'desc' => ['adm.username' => SORT_DESC],
            'label' => 'admin_comment'
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
 

        // grid filtering conditions
        $query->andFilterWhere([
            'order.id' => $this->id,
            'order.user_id' => $this->user_id,
            'order.date' => $this->date,
            'order.date_status' => $this->date_status,
            'order.date_admin_comment' => $this->date_admin_comment,
            'order.admin_archive' => $this->admin_archive,
            'order.user_archive' => $this->user_archive,
            'order.date_changed' => $this->date_changed,
            'order.user_delete' => $this->user_delete,
            'order.status' => $this->status,
        ]);

//        $adm_status = $this->admin_status;
//        print_r($this); echo '33'; 
        
        $query->andFilterWhere(['like', 'order.products', $this->products])
//            ->andFilterWhere(['>=', 'order.date', $this->date])
            ->andFilterWhere(['like', 'order.dostavka', $this->dostavka])
            ->andFilterWhere(['like', 'order.phone', $this->phone])
//            ->andFilterWhere(['like', 'order.status', $this->status])
            ->andFilterWhere(['like', 'order.admin_status', $this->admin_status])
//            ->andFilterWhere(['like', 'order.admin_status', function($adm_status){
//                if ($adm_status) {
//                    
//                }
//                return '8';
//            }])
            ->andFilterWhere(['like', 'order.client_comment', $this->client_comment])
            ->andFilterWhere(['like', 'order.admin_comment', $this->admin_comment])
            ->andFilterWhere(['like', 'order.who_admin_comment', $this->who_admin_comment])
            ->andFilterWhere(['like', 'order.who_admin_changed', $this->who_admin_changed])
//            ->andFilterWhere(['like', 'user.username', $this->getAttribute('username')]);
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.name', $this->name])
            ->andFilterWhere(['like', 'adm.username', $this->adm_status])
            ->andFilterWhere(['>=', 'order.date', $this->createdFrom])
            ->andFilterWhere(['<=', 'order.date', $this->createdTo]);

        return $dataProvider;
    }
}
