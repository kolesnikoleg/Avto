<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use frontend\models\Settings;
use SoapClient;
use frontend\models\Api;
use frontend\models\Product;



/**
 * This is the model class for table "carts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $product_article
 * @property string $product_price_name
 * @property int $product_id
 */
class Carts extends \yii\db\ActiveRecord
{
    public $user_id;
    public $products;
    public $start_cart;
    
    public function __construct() {
        if (Yii::$app->user->isGuest)
        {
            $this->user_id = -1;
            
            if (isset($_SESSION['cart']))
            {
                foreach ($_SESSION['cart'] as $product)
                {
                    $this->products[]['info'] = json_decode($product['product_info'], true);
                    $this->products[count($this->products) - 1]['count'] = $product['product_count'];
                }
            }
            else
            {
                $this->products = false;
            }
            
            $this->start_cart = false;
        }
        else
        {
            $this->user_id = Yii::$app->user->identity->id;
            
            $products = (new Query())
                            ->select(['*'])
                            ->from('carts')
                            ->where(['user_id' => $this->user_id])
                            ->all();
            
            if ($products !== false AND !empty($products))
            {
                foreach ($products as $product)
                {
                    $this->products[]['info'] = json_decode($product['product_info'], true);
                    $this->products[count($this->products) - 1]['count'] = $product['product_count'];
                    $this->start_cart = (new Query())
                        ->select(['start_cart'])
                        ->from('carts')
                        ->where(['user_id' => Yii::$app->user->identity->id])
                        ->limit(1)
                        ->orderBy('id ASC')
                        ->one()['start_cart'];
                }
            }
            else
            {
                $this->products = false;
                $this->start_cart = false;
            }
        }
    }
    
    public function isNotEmptyCart() {
        if ($this->products !== false AND !empty($this->products)): return true; else: return false; endif;
    }
    
    public function eraseCart() {
        if (Yii::$app->user->isGuest)
        {
            unset ($_SESSION['cart']);
        }
        else
        {
            Yii::$app->db->createCommand("DELETE FROM `carts` WHERE user_id = '".Yii::$app->user->identity->id."'")
                        ->execute();
        }
        return true;
    }
    
    public function delProductCart($id) {
        if (Yii::$app->user->isGuest)
        {
            $products = (new Carts())->getCartAsArray()['products'];
            foreach ($products as $key => &$value)
            {
                if ($value['product_info']['ident'] == $id): array_splice($_SESSION['cart'], $key, 1); $_SESSION['help'] = $key; endif;
            }
        }
        else
        {
            $res = Yii::$app->db->createCommand("DELETE FROM `carts` WHERE user_id = '".Yii::$app->user->identity->id."' AND ident = '".$id."'")
                        ->execute();
            if ($res === false): return false; endif;
        }
        $_SESSION['help_flash'] = ['cart_del_true'];
        return true;
    }
    
    public function setProductCountCart($id, $count) {
        $count = intval($count);
        if (!is_int($count)): return false; endif;
        
        $arr = explode('^^', $id);
        if (substr($arr[0], 4, 3) === 'PAP')
        {
            $article = $arr[2];
            $api_num = substr($arr[0], 8);
            $product = new Product(true, ['api_num' => $api_num, 'article' => $article]);
        }
        else
        {
            $pricelist = $arr[0];
            $article = $arr[2];
            $id_prod = $arr[1];
            $product = new Product(false, ['pricelist' => $pricelist, 'article' => $article, 'id' => $id_prod]);
        }
        if ($product->isCheckMinOrder($count))
        {
        
            if (Yii::$app->user->isGuest)
            {
                $products = (new Carts())->getCartAsArray()['products'];
                foreach ($products as $key => &$value)
                {
                    if ($value['product_info']['ident'] == substr($id, 4)): $cntr = $key; endif;
                }
                $i = 0;
                foreach ($_SESSION['cart'] as &$value)
                {
                    if ($i === $cntr)
                    {
                        $value['product_count'] = $count;
                    }
                    $i++;
                }
            }
            else
            {         
                Yii::$app->db->createCommand("UPDATE `carts` SET product_count = '".$count."' WHERE user_id = '".Yii::$app->user->identity->id."' AND ident = '".substr($id, 4)."'")
                            ->execute();
            }
            $_SESSION['help_flash'] = ['cart_rel_true'];
            return true;
        }
        else
        {
            $_SESSION['help_flash'] = ['min_order_false', $product->min_order];
            return [false];
        }
    }
    
    public function getCartAsArray() {
        if ($this->isNotEmptyCart())
        {
            $res_array = [];

            $res_array['user_id'] = $this->user_id;
            $res_array['start_cart'] = $this->start_cart;
            foreach ($this->products as $product)
            {
                $arr['product_info'] = $product['info'];
                $arr['product_count'] = $product['count'];
                $res_array['products'][] = $arr;
            }

            return $res_array;
        }
        else
        {
            return false;
        }
    }
    
    public function getTotalProductsCart() {
        if ($this->isNotEmptyCart())
        {
            $total = 0;
            foreach ($this->products as $product)
            {
                $total += $product['count'];
            }
            return $total;
        }
        else
        {
            return 0;
        }
    }
    
    public function getTotalProductsPricesCart() {
        if ($this->isNotEmptyCart())
        {
            $total = 0;
            foreach ($this->products as $product)
            {
                $prod_buf = new Product();
                $prod_buf->getFromArrayProduct($product['info']);
                $total += $prod_buf->getPriceProduct() * $product['count'];
            }
            return $total;
        }
        else
        {
            return 0;
        }
    }
    
    public function getTotalProductsPricesCurrencyCart() {
        if ($this->isNotEmptyCart())
        {
            $total = 0;
            foreach ($this->products as $product)
            {
                $prod_buf = new Product();
                $prod_buf->getFromArrayProduct($product['info']);
                $total += $prod_buf->getPriceCurrencyProduct() * $product['count'];
            }
            return $total;
        }
        else
        {
            return 0;
        }
    }
    
    public function isOldCart () {
        if (Yii::$app->user->isGuest) {
            return false;
        } else {
            $date = date('Y-m-d H:i:s');
            $new_date = date('Y-m-d H:i:s', strtotime("-24 hours", strtotime($date)));
            if ($new_date > $this->start_cart): return true; else: return false; endif;
        }
    }
    
    public function getProductCountByIdentCart($ident)
    {
        return (new Query())
            ->select(['product_count'])
            ->from('carts')
            ->where(['ident' => $ident])
            ->limit(1)
            ->one()['product_count'];
    }
    
    
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'integer'],
            [['product_article', 'product_price_name', 'product_id'], 'required'],
            [['product_article', 'product_price_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_article' => 'Product Article',
            'product_price_name' => 'Product Price Name',
            'product_id' => 'Product ID',
        ];
    }
    
    public function getTotalProducts()
    {
        $total = 0;
        
        $res = $this->getAllProductsFromCart();
//        $res = self::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
        
        if ($res !== false AND is_array($res) AND count($res) > 0)
        {
            foreach ($res as $key => $value)
            {
                $total += $value['product_count'];
            }
        }
            
        return $total;
    }
    
//    public function getTotalProductsPriceFromSession()
//    {       
//        $total = 0;
//        $model = new PricesList();
//        $settings = new \frontend\models\Settings();
//        if (isset($_SESSION['cart']))
//        {
//            foreach ($_SESSION['cart'] as $key => $value)
//            {
//                if ($model->getPriceListCurrency($value['product_price_name']) == 'USD')
//                {
//                    $total += $model->getProductPrice($value['product_id'], $value['product_price_name'], $value['product_article']) * (new Settings())->getCurrencyUSD() * $value['count'];
//                }
//                if ($model->getPriceListCurrency($value['product_price_name']) == 'EURO')
//                {
//                    $total += $model->getProductPrice($value['product_id'], $value['product_price_name'], $value['product_article']) * (new Settings())->getCurrencyEURO() * $value['count'];
//                }
//                if ($model->getPriceListCurrency($value['product_price_name']) == 'UAH')
//                {
//                    $total += $model->getProductPrice($value['product_id'], $value['product_price_name'], $value['product_article']) * $value['count'];
//                }
//            }
//        }
//        return $total;
//    }
    
    public function getTotalProductsPrice()
    {
        $total = 0;
        $model = new PricesList();
        $m_markups = new Markups();
        $settings = new \frontend\models\Settings();
        $res = $this->getAllProductsFromCart();
        
        if ($res !== false AND is_array($res) AND count($res) > 0)
        {
            foreach ($res as $key => $value)
            {
                $total += $model->getProductPriceByProduct($value)['price_cur'] * $value['product_count'];
            }
        }
        
        return round($total, 2);
    }
    
//    public function isIssetProductInCart ($id)
//    {
//        $product_cart = self::find()->where(['id' => $id])->one();
//        
//        if (substr($product_cart['product_id'], 0, 3) !== 'API')
//        {
//            $product_price_list = (new \yii\db\Query())
//                ->select(['*'])
//                ->from($product_cart['product_price_name'])
//                ->where(['id' => $product_cart['product_id'], 'article' => $product_cart['product_article']])
//                ->limit(1)
//                ->one();
//
//            if (($product_cart['product_id'] == $product_price_list['id']) AND ($product_cart['product_article'] == $product_price_list['article'] ))
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//        else
//        {
//            $api = (new Api())->getDataApiFromID(substr($product_cart['product_price_name'], 8));
//                
////            return $api;
//            
//            $client = new SoapClient($api['address'],array('encoding'=>'UTF-8'));  
//
//            // авторизация и получение session key
//            $session_key = $client->login($api['login'], $api['password']);
//
//            // поиск запчастей
//            $search = $product_cart['product_article']; // искомая запчасть
//            $result = $client->searchParts($session_key, $search); // возвращает ассоциативные массивы
//            $product_price_list = $result[0];
//
//            if ($product_cart['product_article'] == $product_price_list['article'])
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//    }
//    
//    public function isIssetProductInSessionCart ($value_id)
//    {
//        $product_cart = $_SESSION['cart'][$value_id];
//        
//        $product_price_list = (new \yii\db\Query())
//            ->select(['*'])
//            ->from($product_cart['product_price_name'])
//            ->where(['id' => $product_cart['product_id'], 'article' => $product_cart['product_article']])
//            ->limit(1)
//            ->one();
//        
//        if (($product_cart['product_id'] == $product_price_list['id']) AND ($product_cart['product_article'] == $product_price_list['article'] ))
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }
    
    
    
    public function getProductMinOrder ($product)
    {
        if (substr($product['product_id'], 0, 3) === 'API')
        {
            return (new Api())->getApiPriceListMinOrderByID(substr($product['product_id'], 4));
        }
        else
        {
            return (new Query())
                ->select(['min_order'])
                ->from($product['this_price_name'])
                ->where(['article' => $product['article']])
                ->andWhere(['id' => $product['product_id']])
                ->limit(1)
                ->one()['min_order'];
        }
    }
    
    public function isCheckReloadCountMinOrder ($count, $product)
    {
        $min_order = $this->getProductMinOrder($product);
        if ($min_order === false): return false; endif;
        $min_order = intval($min_order);
        if ($min_order > $count): return false; else: return true; endif;
    }
    
//    public function isCheckReloadCountMinOrderGuest ($count, $product_article, $product_id, $price_name)
//    {
//        $min_order = (new \yii\db\Query())
//            ->select(['min_order'])
//            ->from($price_name)
//            ->where(['id' => $product_id, 'article' => $product_article])
//            ->limit(1)
//            ->one()['min_order'];
//        if ($min_order === false): return false; endif;
//        $min_order = intval($min_order);
//        if ($min_order > $count): return false; else: return true; endif;
//    }
//    
//    
//    public function getProductMinOrderGuest ($product_article, $product_id, $price_name)
//    {
//        $min_order = (new \yii\db\Query())
//            ->select(['min_order'])
//            ->from($price_name)
//            ->where(['id' => $product_id, 'article' => $product_article])
//            ->limit(1)
//            ->one()['min_order'];
//        if ($min_order === false): return false; endif;
//        $min_order = intval($min_order);
//        return $min_order;
//    }
//    
//    public function isCheckReloadCountMinOrderUser ($count, $id)
//    {
//        $prod = (new Query())->from('carts')->where(['id' => $id])->limit(1)->one();
//        
//        $min_order = (new \yii\db\Query())
//            ->select(['min_order'])
//            ->from($prod['product_price_name'])
//            ->where(['id' => $prod['product_id'], 'article' => $prod['product_article']])
//            ->limit(1)
//            ->one()['min_order'];
//        if ($min_order === false): return false; endif;
//        $min_order = intval($min_order);
//        if ($min_order > $count): return false; else: return true; endif;
//    }
//    
//    public function getProductMinOrderUser ($id)
//    {
//        $prod = (new Query())->from('carts')->where(['id' => $id])->limit(1)->one();
//        
//        $min_order = (new \yii\db\Query())
//            ->select(['min_order'])
//            ->from($prod['product_price_name'])
//            ->where(['id' => $prod['product_id'], 'article' => $prod['product_article']])
//            ->limit(1)
//            ->one()['min_order'];
//        if ($min_order === false): return false; endif;
//        $min_order = intval($min_order);
//        return $min_order;
//    }
    
//    public function getAllCartsProducts()
//    {
//        if (Yii::$app->user->isGuest)
//        {
//            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : false;
//        }
//        else
//        {
//            $cart = self::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//        }
//        
//        $products = [];
//        
//        if (Yii::$app->user->isGuest)
//        {
//            if (isset($_SESSION['cart']))
//            {
//                foreach ($cart as $key => $value)
//                {
//               
//                    if (self::isIssetProductInSessionCart($key))
//                    {
//                        $products[] = (new Query())->from($value['product_price_name'])->where(['id' => $value['product_id']])->limit(1)->one();
//                    }
//                    else
//                    {
//                        $products['find'] = $value['product_article'];
//                    }
//                }
//            }
//        }
//        else
//        {
//            foreach ($cart as $key => $value)
//            {
//                if (self::isIssetProductInCart($value['id']))
//                {
//                    $api = (new Api())->getDataApiFromID(substr($value['product_price_name'], 8));
//                
//                    $client = new SoapClient($api['address'],array('encoding'=>'UTF-8'));  
//
//                    // авторизация и получение session key
//                    $session_key = $client->login($api['login'], $api['password']);
//
//                    // поиск запчастей
//                    $search = Yii::$app->request->post('search_string'); // искомая запчасть
//                    $result = $client->searchParts($session_key, $value['product_article']); // возвращает ассоциативные массивы
//                    $result = $result[0];
//                    
//                    $products['article'] = $result['article'];
//                    $products['price'] = $result['price'];
//                }
//                else
//                {
//                    $products['find'] = $value['product_article'];
//                }
//            }
//        }
//        
//        return $products;
//    }
//    
//    public function getAllCartsProductsFromSession()
//    {
//        $cart = self::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
//        
//        $products = [];
//        foreach ($cart as $key => $value)
//        {
//            if (self::isIssetProductInCart($value['id']))
//            {
//                $products[] = (new Query())->from($value['product_price_name'])->where(['id' => $value['product_id']])->limit(1)->one();
//            }
//            else
//            {
//                $products['find'] = $value['product_article'];
////                $products[] = (new Query())->from($value['product_price_name'])->where(['id' => $value['product_id']])->limit(1)->one();
//            }
//        }
//        return $products;
//    }
    
    public function checkOwnCart ($id_prod)
    {
        $prod = (new Query())->from('carts')->where(['id' => $id_prod])->limit(1)->one();
        
        if ($prod['user_id'] == Yii::$app->user->identity->id) return true;
        
        return false;
    }
    
    public function getProductsCountFromSessionByPricelistProduct($this_price_name, $id, $article)
    {
        if (isset($_SESSION['cart']))
        {
            foreach ($_SESSION['cart'] as $key => $value)
            {
                if ($value['product_price_name'] == $this_price_name AND $value['product_id'] == $id AND $value['product_article'])
                {
                    return $value['count'];
                }
            }
        }
        else
        {
            return false;
        }
    }
    
    public function getProductsArticleFromSessionByPricelistProduct($this_price_name, $id, $article)
    {
        if (isset($_SESSION['cart']))
        {
            foreach ($_SESSION['cart'] as $key => $value)
            {
                if ($value['product_price_name'] == $this_price_name AND $value['product_id'] == $id AND $value['product_article'])
                {
                    return $value['product_article'];
                }
            }
        }
        else
        {
            return false;
        }
    }
    
    public function getProductsPriceNameFromSessionByPricelistProduct($this_price_name, $id, $article)
    {
        if (isset($_SESSION['cart']))
        {
            foreach ($_SESSION['cart'] as $key => $value)
            {
                if ($value['product_price_name'] == $this_price_name AND $value['product_id'] == $id AND $value['product_article'])
                {
                    return $value['product_price_name'];
                }
            }
        }
        else
        {
            return false;
        }
    }
    
    public function getProductsIdFromSessionByPricelistProduct($this_price_name, $id, $article)
    {
        if (isset($_SESSION['cart']))
        {
            foreach ($_SESSION['cart'] as $key => $value)
            {
                if ($value['product_price_name'] == $this_price_name AND $value['product_id'] == $id AND $value['product_article'])
                {
                    return $key;
                }
            }
        }
        else
        {
            return false;
        }
    }
    
    public function isIssetBtnImportCart()
    {
        if (Yii::$app->user->isGuest)
        {
            return false;
        }
        else
        {
            if (isset($_SESSION['cart']))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    
    
    // OOP
    
    /**
     * {@inheritdoc}
     * $product array
     */
    public function addProductToCart ($product, $count)
    {
        if (!$this->isIssetProductInCart ($product))
        {
            if ($this->isCheckReloadCountMinOrder($count, $product))
            {
                if ($this->addProductToCartFinish ($product, $count)): return true; else: return false; endif;
            }
            else
            {
                return [false, 'min_order', $this->getProductMinOrder ($product)];
            }
        }
        else
        {
            return [false, 'isset'];
        }
    }
    
    public function isIssetProductInCart ($product)
    {
        $products_from_cart = $this->getAllProductsFromCart();
        
        if (is_array($products_from_cart))
        {
            foreach ($products_from_cart as $product_from_cart)
            {
                if ($product_from_cart['article'] === $product['article'] AND $product_from_cart['this_price_name'] === $product['this_price_name'] AND $product_from_cart['product_id'] === $product['product_id'])
                {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function getAllProductsFromCart ($id = false)
    {
        if (Yii::$app->user->isGuest)
        {
            if ($id === false)
            {
                if (isset($_SESSION['cart'])): return $_SESSION['cart']; else: return false; endif;
            }
            else
            {
                if (isset($_SESSION['cart'])): return $_SESSION['cart'][$id]; else: return false; endif;
            }
        }
        else
        {
            
            if ($id === false)
            {
                $all_products = (new Query())
                    ->select(['*'])
                    ->from('carts')
                    ->where(['user_id' => Yii::$app->user->identity->id])
                    ->all();
            }
            else
            {
                $all_products = (new Query())
                    ->select(['*'])
                    ->from('carts')
                    ->where(['user_id' => Yii::$app->user->identity->id])
                    ->andWhere(['id' => $id])
                    ->all();
            }

            if ($all_products === false): return false; endif;

            $buf_arr = [];
            $i = 0;

            foreach ($all_products as $key => $product)
            {
                $buf_arr[$i]['id'] = $key;
                $buf_arr[$i]['article'] = $product['product_article'];
                $buf_arr[$i]['this_price_name'] = $product['product_price_name'];
                $buf_arr[$i]['product_count'] = $product['product_count'];
                $buf_arr[$i]['product_id'] = $product['product_id'];
                
                if (substr($product['product_id'], 0, 3) == 'API')
                {
                    $buf_arr[$i]['currency'] = (new API())->getApiPriceListCurrencyByID(substr($product['product_id'], 4));
                }
                else
                {
                    $buf_arr[$i]['currency'] = (new PricesList())->getPriceListCurrency($product['product_price_name']);
                }
                    
                $buf = json_decode($product['product_info'], true);
                
                if (substr($product['product_id'], 0, 3) == 'API')
                {
                    $buf_arr[$i]['term'] = $buf['term'];
                }
                else
                {
                    $buf_arr[$i]['term'] = (new PricesList())->getPriceListTerm($product['product_price_name']);
                }
                
                $buf_arr[$i]['manufacturer'] = $buf['manufacturer'];
                $buf_arr[$i]['name'] = $buf['name'];
                $buf_arr[$i]['weight'] = $buf['weight'];
                $buf_arr[$i]['min_order'] = $buf['min_order'];
                $buf_arr[$i]['price'] = $buf['price'];

                $i++;
            }
            
            return $buf_arr;
        }
    }
    
    public function isProductToCartFromApi ($product)
    {
        return ( substr($product['product_id'], 0, 3) === 'API' ? true : false );
    }
    
    public function addProductToCartFinish ($product, $count)
    {
        
//        
//        $api = $api_obj->getDataApiFromID($api_obj->getApiNumFromProduct($product));
//
//        $client = new SoapClient($api['address'],array('encoding'=>'UTF-8'));  
//
//        $session_key = $client->login($api['login'], $api['password']);
//        $search = $product['product_article']; // искомая запчасть
//        $result = $client->searchParts($session_key, $search); // возвращает ассоциативные массивы
//        $product = $result[0];

        if ($product === false OR !is_array($product)): return false; endif;
        
        if (Yii::$app->user->isGuest)
        {
            if (isset($_SESSION['cart'])): $cart_count = count($_SESSION['cart']); else: $cart_count = 0; endif;

            $_SESSION['cart'][$cart_count]['name'] = $product['name'];
            $_SESSION['cart'][$cart_count]['manufacturer'] = $product['manufacturer'];
            $_SESSION['cart'][$cart_count]['article'] = $product['article'];
            $_SESSION['cart'][$cart_count]['price'] = $product['price'];
            $_SESSION['cart'][$cart_count]['weight'] = $product['weight'];
            $_SESSION['cart'][$cart_count]['product_count'] = $count;
            $_SESSION['cart'][$cart_count]['available'] = $product['available'];
            $_SESSION['cart'][$cart_count]['product_id'] = $product['product_id'];
            $_SESSION['cart'][$cart_count]['currency'] = $product['currency'];
            $_SESSION['cart'][$cart_count]['min_order'] = $product['min_order'];
            
            if (substr($product['product_id'], 0, 3) == 'API')
            {
                $_SESSION['cart'][$cart_count]['this_price_name'] = 'prc_' . $product['this_price_name'];
                $_SESSION['cart'][$cart_count]['term'] = $product['term'] . ' ДНЕЙ';
            }
            else
            {
                $_SESSION['cart'][$cart_count]['this_price_name'] = $product['this_price_name'];
                $_SESSION['cart'][$cart_count]['term'] = $product['term'];
            }
            
            

            return true;
        }
        else
        {
            
            $buf_arr['manufacturer'] = $product['manufacturer'];
            $buf_arr['name'] = $product['name'];
            $buf_arr['min_order'] = $product['min_order'];
            $buf_arr['price'] = $product['price'];
            $buf_arr['weight'] = $product['weight'];
            
            if (substr($product['product_id'], 0, 3) == 'API')
            {
                $buf_arr['term'] = $product['term'] . ' ДНЕЙ';
            }
            else
            {
                $buf_arr['term'] = $product['term'];
            }
            
            $sql = "INSERT INTO `carts` (";
            $sql .= "user_id, product_article, product_price_name, product_id, product_info, product_count";
            $sql .= ") VALUES (";
            $sql .= "'".Yii::$app->user->identity->id."', ";
            $sql .= "'".$product['article']."', ";
            
            
            if (substr($product['product_id'], 0, 3) == 'API')
            {
                $sql .= "'prc_".$product['this_price_name']."', ";
            }
            else
            {
                $sql .= "'".$product['this_price_name']."', ";
            }
            
            
            $sql .= "'".$product['product_id']."', ";
            $sql .= "'".json_encode($buf_arr, JSON_UNESCAPED_UNICODE)."', ";
            $sql .= "'".$count."'";
            $sql .= ')';
            
            $res = Yii::$app->db->createCommand($sql)->execute();
        
            if ($res): return true; else: return false; endif;
        }
    }
}
