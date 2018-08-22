<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use SoapClient;

/**
 * This is the model class for table "api".
 *
 * @property int $id
 * @property string $address
 * @property string $login
 * @property string $password
 * @property string $currency
 */
class Api extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'api';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'login', 'password', 'currency'], 'required'],
            [['address', 'login', 'password'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'login' => 'Login',
            'password' => 'Password',
            'currency' => 'Currency',
        ];
    }
    
    public function getAllApisID()
    {
        return  (new Query())
            ->select(['id'])
            ->from('api')
            ->all();
    }
    
    public function getDataApiFromID($id)
    {
        return  (new Query())
            ->select(['*'])
            ->from('api')
            ->where(['id' => $id])
            ->limit(1)
            ->one();
    }
    
    public function getApiPriceListNameByID($id)
    {
        return  (new Query())
            ->select(['name'])
            ->from('api')
            ->where(['id' => $id])
            ->limit(1)
            ->one()['name'];
    }
    
    public function getWeightForApi ($api_num, $value)
    {
        if ($api_num === '1') return $value / 1000 . ' КГ';
    }
    
    public function getNameForApi ($api_num, $value)
    {
        if ($api_num === '1') return $value;
    }
    
    public function getArticleForApi ($api_num, $value)
    {
        if ($api_num === '1') return $value;
    }
    
    public function getPriceForApi ($api_num, $value)
    {
        if ($api_num === '1') return str_replace(',', '.', $value);
    }
    
    public function getTermForApi ($api_num, $value)
    {
        if ($api_num === '1') return $value . ' ДНЕЙ';
    }
    
    public function getAvailableForApi ($api_num, $value)
    {
        if ($api_num === '1') return $value . ' ШТ';
    }
    
    public function getApiNumFromProduct ($product)
    {
        return substr($product['product_id'], 4);
    }
        
    public function getApiPriceListCurrencyByID ($id)
    {
        return  (new Query())
            ->select(['currency'])
            ->from('api')
            ->where(['id' => $id])
            ->limit(1)
            ->one()['currency'];
    }
    
    public function getApiPriceListMinOrderByID ($api_num)
    {
        return  (new Query())
            ->select(['min_order'])
            ->from('api')
            ->where(['id' => $api_num])
            ->limit(1)
            ->one()['min_order'];
    }
    
    public function getProductByArticle ($article, $api_num)
    {        
        $api = $this->getDataApiFromID($api_num);
                
        $client = new SoapClient($api['address'],array('encoding'=>'UTF-8'));
        $session_key = $client->login($api['login'], $api['password']);
        $search = Yii::$app->request->post('search_string'); // искомая запчасть
        $result = $client->searchParts($session_key, $article); // возвращает ассоциативные массивы
        $result = $result[0];

        if ($result === false OR !is_array($result)): return false; endif;
        
        $product = [];
        $product['article'] = $result['article'];
        $product['product_id'] = 'API-'.$api_num;;
        $product['price'] = $result['price'];
        $product['name'] = $result['name'];
        $product['weight'] = $result['weight'];
        $product['manufacturer'] = $result['manufacturer'];
        $product['term'] = $result['delivery'];
        $product['available'] = $result['available'];
        $product['currency'] = $this->getApiPriceListCurrencyByID($api_num);;
        $product['min_order'] = $this->getApiPriceListMinOrderByID($api_num);
        $product['this_price_name'] = 'PAP-'.$api_num;
        
        return $product;
    }
}
