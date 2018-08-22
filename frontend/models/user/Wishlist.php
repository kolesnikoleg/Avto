<?php

namespace frontend\models\user;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "wishlist".
 *
 * @property int $id
 * @property int $user_id
 * @property string $product_article
 * @property string $product_price_name
 * @property string $product_id
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['product_article', 'product_price_name', 'product_id'], 'required'],
            [['product_article', 'product_price_name', 'product_id'], 'string', 'max' => 255],
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
    
    public function checkOwnWish ($id_wish)
    {
        $wish = (new Query())->from('wishlist')->where(['id' => $id_wish])->limit(1)->one();
        
        if ($wish['user_id'] == Yii::$app->user->identity->id) return true;
        
        return false;
    }
}
