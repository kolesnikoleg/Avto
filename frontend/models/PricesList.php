<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use frontend\models\Markups;

/**
 * This is the model class for table "prices_list".
 *
 * @property int $id
 * @property string $name
 * @property string $term
 * @property string $currency
 */
class PricesList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'term', 'currency'], 'required'],
            [['name', 'term'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 45],
            ['name', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'term' => 'Term',
            'currency' => 'Currency',
        ];
    }
    
    public function getListPricesAll()
    {
        $row = (new \yii\db\Query())
            ->select(['name'])
            ->from('prices_list')
            ->all();
        $result = [];
        foreach ($row as $key => $value)
        {
            $result[] = $value['name'];
        }
        return $result;
    }
    
    public function setTotalRowsNewPrice ($rows_count, $price_name)
    {
        $res = Yii::$app->db->createCommand("UPDATE `prices_list` SET `rows` = '".$rows_count."' WHERE `name` = 'prc_".$price_name."'")->execute();
        if ($res): return true; else: return false; endif;
    }
    
    public function getTotalRowsNewPrice ($price_name)
    {
        $res = Yii::$app->db->createCommand("SELECT rows FROM `prices_list` WHERE `name` = 'prc_".$price_name."'")->queryOne()['rows'];
        if ($res): return $res; else: return false; endif;
    }
    
    public function getPercentLoadedNewPrice ($price_name, $already_loaded)
    {
        $res = $this->getTotalRowsNewPrice($price_name) / 100 * $already_loaded;
        if ($res): return $already_loaded / ($this->getTotalRowsNewPrice($price_name) / 100); else: return false; endif;
    }
    
    public function getPriceListTerm($name)
    {
        return (new \yii\db\Query())
            ->select(['term'])
            ->from('prices_list')
            ->where(['name' => $name])
            ->one()['term'];
    }
    
    public function getPriceListCurrency($name)
    {
        return (new \yii\db\Query())
            ->select(['currency'])
            ->from('prices_list')
            ->where(['name' => $name])
            ->one()['currency'];
    }
    
    public function getProductPrice ($id_product_pricelist, $pricelist_name, $article_product)
    {
        $price = floatval(str_replace(',', '.', (new Query())->select('price')->from($pricelist_name)->where(['id' => $id_product_pricelist, 'article' => $article_product])->limit(1)->one()['price']));
        
        $m_markups = new Markups();
        
        $price_new = 0;
        
        if (Yii::$app->user->isGuest)
        {
            if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
            {
                $price_new = round($price * ((100 + ($m_markups->getMarkupVal($pricelist_name, $price))) / 100), 2);
            }
            if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
            {
                $price_new = round($price + $m_markups->getMarkupVal($pricelist_name, $price), 2);
            }
        }
        else
        {
            if ((new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka') == 0)
            {
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
                {
                    $price_new = round($price * ((100 + ($m_markups->getMarkupVal($pricelist_name, $price))) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
                {
                    $price_new = round($price + $m_markups->getMarkupVal($pricelist_name, $price), 2);
                }
            }
            else
            {
                $skidka_val = (new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka_val');
                
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
                {
                    $price_new = round($price * ((100 + (  $m_markups->getMarkupVal($pricelist_name, $price) - ( $m_markups->getMarkupVal($pricelist_name, $price) / 100 * $skidka_val ) )) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
                {
                    $price_new = round($price + ($m_markups->getMarkupVal($pricelist_name, $price) - ( $m_markups->getMarkupVal($pricelist_name, $price) / 100 * $skidka_val )), 2);
                }
            }
        }
        
        return $price_new;
    }
    
    public function getProductPriceByProduct ($product)
    {
        $price = str_replace(',', '.', $product['price']);
        $price = floatval($price);
        $m_markups = new Markups();
        
        $price_new = 0;
        
        
//        print_r($product); exit();
        
        if (Yii::$app->user->isGuest)
        {
            if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '*')
            {
                $price_new = round($price * ((100 + ($m_markups->getMarkupVal($product['this_price_name'], $price))) / 100), 2);
            }
            if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '+')
            {
                $price_new = round($price + $m_markups->getMarkupVal($product['this_price_name'], $price), 2);
            }
        }
        else
        {
            if ((new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka') == 0)
            {
                if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '*')
                {
                    $price_new = round($price * ((100 + ($m_markups->getMarkupVal($product['this_price_name'], $price))) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '+')
                {
                    $price_new = round($price + $m_markups->getMarkupVal($product['this_price_name'], $price), 2);
                }
            }
            else
            {
                $skidka_val = (new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka_val');
                
                if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '*')
                {
                    $price_new = round($price * ((100 + (  $m_markups->getMarkupVal($product['this_price_name'], $price) - ( $m_markups->getMarkupVal($product['this_price_name'], $price) / 100 * $skidka_val ) )) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($product['this_price_name'], $price) == '+')
                {
                    $price_new = round($price + ($m_markups->getMarkupVal($product['this_price_name'], $price) - ( $m_markups->getMarkupVal($product['this_price_name'], $price) / 100 * $skidka_val )), 2);
                }
            }
        }
        
        
        $settings = new \frontend\models\Settings();
        
        if ($product['currency'] === 'USD' ):
            $price_currency = $price_new * $settings->getCurrencyUSD();
        endif;
        
        if ($product['currency'] === 'EURO' ):
            $price_currency = $price_new * $settings->getCurrencyEURO();
        endif;
        
        if ($product['currency'] === 'UAH' ):
            $price_currency = $price_new * $settings->getCurrencyEURO();
            $price_new = -1;
        endif;
        
        return ['price_val' => $price_new, 'price_cur' => $price_currency];
    }
    
    public function getApiProductPrice ($price, $pricelist_name)
    {        
        $m_markups = new Markups();
        
        $price_new = 0;
        
        if (Yii::$app->user->isGuest)
        {
            if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
            {
                $price_new = round($price * ((100 + ($m_markups->getMarkupVal($pricelist_name, $price))) / 100), 2);
            }
            if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
            {
                $price_new = round($price + $m_markups->getMarkupVal($pricelist_name, $price), 2);
            }
        }
        else
        {
            if ((new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka') == 0)
            {
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
                {
                    $price_new = round($price * ((100 + ($m_markups->getMarkupVal($pricelist_name, $price))) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
                {
                    $price_new = round($price + $m_markups->getMarkupVal($pricelist_name, $price), 2);
                }
            }
            else
            {
                $skidka_val = (new User())->getFieldByIdUser(Yii::$app->user->identity->id, 'skidka_val');
                
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '*')
                {
                    $price_new = round($price * ((100 + (  $m_markups->getMarkupVal($pricelist_name, $price) - ( $m_markups->getMarkupVal($pricelist_name, $price) / 100 * $skidka_val ) )) / 100), 2);
                }
                if ($m_markups->getMarkupZnak($pricelist_name, $price) == '+')
                {
                    $price_new = round($price + ($m_markups->getMarkupVal($pricelist_name, $price) - ( $m_markups->getMarkupVal($pricelist_name, $price) / 100 * $skidka_val )), 2);
                }
            }
        }
        
        return $price_new;
    }
    
    public function getProductBy ($pricelist, $article, $id)
    {
        $result = (new Query())
            ->select(['*'])
            ->from($pricelist)
            ->where(['article' => $article, 'id' => $id])
            ->limit(1)
            ->one();
        
        if ($result === false OR !is_array($result)): return false; endif;
        
        $product = [];
        $product['article'] = $result['article'];
        $product['product_id'] = $result['id'];
        $product['price'] = $result['price'];
        $product['name'] = $result['name'];
        $product['weight'] = $result['weight'];
        $product['manufacturer'] = $result['manufacturer'];
        $product['term'] = $this->getPriceListTerm($result['this_price_name']);
        $product['currency'] = $this->getPriceListCurrency($result['this_price_name']);
        $product['available'] = $result['count'];
        $product['min_order'] = $result['min_order'];
        $product['this_price_name'] = $result['this_price_name'];
        
        return $product;
    }
}
