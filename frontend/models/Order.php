<?php

namespace frontend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $date
 * @property string $products
 * @property string $dostavka
 * @property string $phone
 * @property string $status
 * @property string $admin_status
 * @property int $date_status
 * @property string $client_comment
 * @property string $admin_comment
 * @property int $date_admin_comment
 * @property string $who_admin_comment
 * @property int $admin_archive
 * @property int $user_archive
 * @property int $date_changed
 * @property string $who_admin_changed
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required', 'message' => 'Обязательное поле!'],
            [['client_comment'], 'string'],
            [['phone'], 'string', 'max' => 255],
            [['client_comment'], 'default', 'value' => -1],
            [['dostavka'], 'default', 'value' => -1],
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
            'date' => 'Date',
            'products' => 'Products',
            'dostavka' => 'Адрес доставки',
            'phone' => 'Phone',
            'status' => 'Status',
            'admin_status' => 'Admin Status',
            'date_status' => 'Date Status',
            'client_comment' => 'Комментарий к заказу',
            'admin_comment' => 'Admin Comment',
            'date_admin_comment' => 'Date Admin Comment',
            'who_admin_comment' => 'Who Admin Comment',
            'admin_archive' => 'Admin Archive',
            'user_archive' => 'User Archive',
            'date_changed' => 'Date Changed',
            'who_admin_changed' => 'Who Admin Changed',
        ];
    }
    
    public function formName() {
        return '';
    }
    
    public function getEmptyPhone ()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        if ($user->phone == '-1') return ''; else return $user->phone;
    }
    
    public function getEmptyDostavka ()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        if ($user->address == '-1') return ''; else return $user->address;
    }
    
    public function getOrderTotalPrice ($id)
    {
        $products = self::findOne(['id' => $id])->products;
        $products = json_decode($products);
        return $products->total_price;
    }
    
    public function getOrderDebt ($id)
    {
        $products = self::findOne(['id' => $id])->products;
        $products = json_decode($products);
        return $products->total_price - $products->total_payed;
    }
    
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status']);
    }
    
    public function checkOwnOrder ($id_ord)
    {
        $ord = (new Query())->from('order')->where(['id' => $id_ord])->limit(1)->one();
        
        if ($ord['user_id'] == Yii::$app->user->identity->id) return true;
        
        return false;
    }
}
