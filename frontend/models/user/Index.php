<?php

namespace frontend\models\user;

use Yii;
use yii\base\Model;
use yii\db\Query;



class Index extends yii\base\Model
{
    public function getDateReg ()
    {
        $sql = new Query();
        $date = $sql->select('created_at')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $date['created_at'];
    }
    
    /**
 * Password reset form
 */
    public function getBalance ()
    {
        $sql = new Query();
        $data = $sql->select('balance')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['balance'];
    }
    
    public function getSkidka ()
    {
        $sql = new Query();
        $data = $sql->select('skidka_val')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['skidka_val'];
    }
    
    public function getPhone ()
    {
        $sql = new Query();
        $data = $sql->select('phone')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['phone'];
    }
    
    public function getEmailWarning ()
    {
        $sql = new Query();
        $data = $sql->select('email_warning')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['email_warning'];
    }
    
    public function getName ()
    {
        $sql = new Query();
        $data = $sql->select('name')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['name'];
    }
    
    public function getAddress ()
    {
        $sql = new Query();
        $data = $sql->select('address')->from('user')->where(['username' => Yii::$app->user->identity->username])->one();
        return $data['address'];
    }
    
    public function getMyAllOrdersCount ()
    {
        $sql = new Query();
        $data = $sql->select('id')->from('order')->where(['user_id' => Yii::$app->user->identity->id, 'user_delete' => -1])->count();
        return $data;
    }
    
    public function getMyLastOrder ()
    {
        $sql = new Query();
        $data = $sql->select('date')->from('order')->where(['user_id' => Yii::$app->user->identity->id, 'user_delete' => -1])->orderBy('id DESC')->limit(1)->one();
        return $data['date'];
    }
    
    public function getMyBoughtPartsCount () {
        $sql = new Query();
        $data = $sql->select('products')->from('order')->where(['user_id' => Yii::$app->user->identity->id, 'user_delete' => -1])->all();
        
        $total_parts = 0;
        foreach ($data as $key => $value)
        {
            $buf = json_decode($value['products'], true);
            
            foreach ($buf as $key_1 => $value_1)
            {
                $total_parts += $value_1['count'];
            }
        }
        return $total_parts;
    }
    
    public function getMyBoughtPartsPriceCount () {
        $sql = new Query();
        $data = $sql->select('products')->from('order')->where(['user_id' => Yii::$app->user->identity->id, 'user_delete' => -1])->all();
        
        $total_parts_price = 0;
        foreach ($data as $key => $value)
        {
            $buf = json_decode($value['products'], true);
            
            $total_parts_price += $buf['total_price'];
            
           // {"0":{"name":"\u041a\u043e\u043c\u043f\u0440\u0435\u0441\u0441\u043e\u0440 \u043a\u043e\u043b\u0435\u043d\u0432\u0430\u043b\u0430","weight":"5.26","manufacturer":"LEXUS","id":6,"article":"789789","price_list":"prc_ASIA","count":4},"1":{"name":"\u041a\u043e\u043c\u043f\u0440\u0435\u0441\u0441\u043e\u0440 \u043a\u043e\u043b\u0435\u043d\u0432\u0430\u043b\u0430","weight":"5.26","manufacturer":"LEXUS","id":6,"article":"789789","price_list":"prc_ASIA","count":4},"total_price":12960,"total_payed":0}
        }
        return $total_parts_price;
    }
}
