<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\db\Query;
use SoapClient;
use Yii;
use frontend\models\Api;
use frontend\models\Markups;
use frontend\models\User;
use frontend\models\Settings;

/**
 * Description of Product
 *
 * @author Home
 */
class Product {
    
    public $api;
    public $api_num;
    public $article;
    public $price_id;
    public $price;
    public $ident;
    public $manufacturer;
    public $term;
    public $min_order;
    public $name;
    public $weight;
    public $currency;
    public $this_price_name;
    
    public function __construct($api = '', $param = '')
    {
        if ($api !== '')
        {
            if ($api === true)
            {
                $api_obj = (new Api())->getDataApiFromID($param['api_num']);

                $client = new SoapClient($api_obj['address'],array('encoding'=>'UTF-8'));
                $session_key = $client->login($api_obj['login'], $api_obj['password']);
                $search = Yii::$app->request->post('search_string'); // искомая запчасть
                $result = $client->searchParts($session_key, $param['article']); // возвращает ассоциативные массивы
                $result = $result[0];

                if ($result === false OR !is_array($result)): return false; endif;

                $this->api = true;
                $this->api_num = $param['api_num'];
                $this->article = $result['article'];
                $this->price_id = false;
                $this->price = str_replace(',', '.', $result['price']);
                $this->manufacturer = $result['manufacturer'];
                $this->term = $result['delivery'] . ' ДНЕЙ';
                $this->min_order = (new Api())->getApiPriceListMinOrderByID($param['api_num']);
                $this->name = $result['name'];
                $this->weight = str_replace(',', '.', $result['weight']);
                $this->currency = (new Api())->getApiPriceListCurrencyByID($param['api_num']);
                $this->this_price_name = (new Api())->getApiPriceListNameByID($param['api_num']);
                $this->ident = $this->this_price_name . '^^' . $this->price_id . '^^' . $this->article;
            }
            else
            {
                $result = (new Query())
                    ->select(['*'])
                    ->from($param['pricelist'])
                    ->where(['article' => $param['article'], 'id' => $param['id']])
                    ->limit(1)
                    ->one();

                if ($result === false OR !is_array($result)): return false; endif;

                $this->api = false;
                $this->api_num = false;
                $this->article = $result['article'];
                $this->price_id = $result['id'];
                $this->price = str_replace(',', '.', $result['price']);
                $this->manufacturer = $result['manufacturer'];
                $this->term = (new PricesList())->getPriceListTerm($result['this_price_name']);
                $this->min_order = $result['min_order'];
                $this->name = $result['name'];
                $this->weight = str_replace(',', '.', $result['weight']);
                $this->currency = (new PricesList())->getPriceListCurrency($result['this_price_name']);
                $this->this_price_name = substr($result['this_price_name'], strlen((new Settings())->getPricelistsPrefix())); 
                $this->ident = $this->this_price_name . '^^' . $this->price_id . '^^' . $this->article;
            }
        }
    }
    
    public function isApi() {
        if ($this->api === true): return true; else: return false; endif;
    }
    
    public function getApi() {
        return $this->api_num;
    }
    
    public function isCheckMinOrder($check_val) {
        if ($check_val < $this->min_order): return false; else: return true; endif;
    }
    
    public function getFromJsonProduct ($string) {
        $result = json_decode($string, true);
        
        if ($result === false OR !is_array($result)): return false; endif;

        $this->api = $result['api'];
        $this->api_num = $result['api_num'];
        $this->article = $result['article'];
        $this->price_id = $result['price_id'];
        $this->price = $result['price'];
        $this->manufacturer = $result['manufacturer'];
        $this->term = $result['term'];
        $this->ident = $result['ident'];
        $this->min_order = $result['min_order'];
        $this->name = $result['name'];
        $this->weight = $result['weight'];
        $this->currency = $result['currency'];
        $this->this_price_name = $result['this_price_name'];
    }
    
    public function getFromArrayProduct ($array) {
        $result = $array;
        
        if ($result === false OR !is_array($result)): return false; endif;

        $this->api = $result['api'];
        $this->api_num = $result['api_num'];
        $this->article = $result['article'];
        $this->price_id = $result['price_id'];
        $this->price = $result['price'];
        $this->manufacturer = $result['manufacturer'];
        $this->term = $result['term'];
        $this->ident = $result['ident'];
        $this->min_order = $result['min_order'];
        $this->name = $result['name'];
        $this->weight = $result['weight'];
        $this->currency = $result['currency'];
        $this->this_price_name = $result['this_price_name'];
    }
    
    public function getPriceListWithPrefixProduct() {
        return (new Settings())->getPricelistsPrefix() . $this->this_price_name;
    }
    
    public function getPriceCurrencyProduct() {
        $settings = new \frontend\models\Settings();
        
        if ($this->currency === 'USD'): return $this->getPriceProduct() * $settings->getCurrencyUSD(); endif;
        if ($this->currency === 'EURO'): return $this->getPriceProduct() * $settings->getCurrencyEURO(); endif;
        if ($this->currency === 'UAH'): return $this->getPriceProduct(); endif;
    }
    
    public function getPriceProduct() {
        $price = $this->price;
        $m_markups = new Markups();
        $price_new = 0;
        
        if (Yii::$app->user->isGuest)
        {
            if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '*')
            {
                $price_new = round($price * ((100 + ($m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price))) / 100), 2);
            }
            if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '+')
            {
                $price_new = round($price + $m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price), 2);
            }
        }
        else
        {
            if ((new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka') == 0)
            {
                if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '*')
                {
                    $price_new = round($price * ((100 + ($m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price))) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '+')
                {
                    $price_new = round($price + $m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price), 2);
                }
            }
            else
            {
                $skidka_val = (new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka_val');
                
                if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '*')
                {
                    $price_new = round($price * ((100 + (  $m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price) - ( $m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price) / 100 * $skidka_val ) )) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($this->getPriceListWithPrefixProduct(), $price) == '+')
                {
                    $price_new = round($price + ($m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price) - ( $m_markups->getMarkupVal($this->getPriceListWithPrefixProduct(), $price) / 100 * $skidka_val )), 2);
                }
            }
        }
        
        return $price_new;
        
    }
    
    public function isRealProduct() {
        if ($this->isApi())
        {
            $api_obj = (new Api())->getDataApiFromID($this->api_num);

            $client = new SoapClient($api_obj['address'],array('encoding'=>'UTF-8'));
            $session_key = $client->login($api_obj['login'], $api_obj['password']);
            $result = $client->searchParts($session_key, $this->article);
            $result = $result[0];

            if ($result === false OR !is_array($result) OR empty($result)): return false; else: return true; endif;
        }
        else
        {
            $result = (new Query())
                ->select(['*'])
                ->from('prc_' . $this->this_price_name)
                ->where(['id' => $this->price_id, 'article' => $this->article])
                ->limit(1)
                ->one();

            if ($result === false OR !is_array($result) OR empty($result)): return false; else: return true; endif;
        }
    }
    
    public function getProductAsArray() {
        $result = [];
        
        $result['api'] = $this->api;
        $result['api_num'] = $this->api_num;
        $result['article'] = $this->article;
        $result['price_id'] = $this->price_id;
        $result['price'] = $this->price;
        $result['manufacturer'] = $this->manufacturer;
        $result['term'] = $this->term;
        $result['ident'] = $this->ident;
        $result['min_order'] = $this->min_order;
        $result['name'] = $this->name;
        $result['weight'] = $this->weight;
        $result['currency'] = $this->currency;
        $result['this_price_name'] = $this->this_price_name;
        
        return $result;
    }
    
    public function jsonEncodeProduct() {
        $result = $this->getProductAsArray();
        
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    
    public function addProductCart ($count, $force_date = false) {
        if ($this->isCartConsistProduct() === false)
        {
            if ($this->isCheckMinOrder($count))
            {
                if (Yii::$app->user->isGuest)
                {
                    $arr['product_info'] = $this->jsonEncodeProduct();
                    $arr['product_count'] = $count;

                    $_SESSION['cart'][] = $arr;
                }
                else
                {
                    $sql = '';
                    $sql .= "INSERT INTO `carts` (";
                    $sql .= "user_id, ";
                    $sql .= "ident, ";
                    $sql .= "product_info, ";
                    $sql .= "start_cart, ";
                    $sql .= "product_count";
                    $sql .= ") VALUES (";
                    $sql .= "'" . Yii::$app->user->identity->id . "', ";
                    $sql .= "'" . $this->ident . "', ";
                    $sql .= "'" . $this->jsonEncodeProduct() . "', ";
                    
                    if ($force_date === false) {
                        if ((new Carts())->isNotEmptyCart())
                        {
                            $sql .= "'" . (new Carts())->start_cart . "', ";
                        }
                        else
                        {
                            $sql .= "'" . date('Y-m-d H:i:s') . "', ";
                        }
                    } else {
                        $sql .= "'" . $force_date . "', ";
                    }
                    
                    
                    
                    $sql .= "'" . $count . "'";
                    $sql .= ")";

                    Yii::$app->db->createCommand($sql)->execute();
                }

                return true;
            }
            else
            {
                return [false, 'min_order', $this->min_order];
            }
        }
        else
        {
            return [false, 'isset'];
        }
    }
    
    public function isCartConsistProduct() {
        $cart_products = (new Carts())->getCartAsArray();
        if ($cart_products === false): return false; else: $cart_products = $cart_products['products']; endif;
        
        foreach ($cart_products as $key => $product)
        {
           if ($product['product_info']['this_price_name'] == $this->this_price_name AND $product['product_info']['article'] == $this->article AND $product['product_info']['price'] == $this->price)
           {
               return $key;
           }
        }
        
        return false;
    }
    
    public function delProductCart($ident)
    {
        Yii::$app->db->createCommand("DELETE FROM `carts` WHERE ident = '".$ident."'")
            ->execute();
    }
}
