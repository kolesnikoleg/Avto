<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "api".
 *
 * @property int $id
 * @property string $address
 * @property string $login
 * @property string $password
 * @property string $currency
 * @property string $name
 * @property int $min_order
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
            [['address', 'login', 'password', 'currency', 'name', 'min_order'], 'required'],
            [['min_order'], 'integer'],
            [['address', 'login', 'password'], 'string', 'max' => 255],
            [['currency', 'name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Веб-сайт',
            'login' => 'Логин',
            'password' => 'Пароль',
            'currency' => 'Валюта',
            'name' => 'Название',
            'min_order' => 'Мин. заказ',
        ];
    }
}
