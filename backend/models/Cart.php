<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $product_article
 * @property string $product_price_name
 * @property string $product_id
 * @property int $product_count
 * @property string $product_info
 * @property string $start_cart
 * @property string $ident
 */
class Cart extends \yii\db\ActiveRecord
{
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
            [['user_id', 'product_count'], 'integer'],
            [['product_count'], 'required'],
            [['product_info'], 'string'],
            [['start_cart'], 'safe'],
            [['product_article', 'product_price_name', 'product_id', 'ident'], 'string', 'max' => 255],
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
            'product_count' => 'Количество',
            'product_info' => 'Product Info',
            'start_cart' => 'Дата создания',
            'ident' => 'Ident',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
