<?php

namespace backend\models;

use Yii;
use yii\i18n\Formatter;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $skidka
 * @property int $skidka_val
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property string $comment
 * @property int $sending
 * @property string $admin_comment
 * @property int $total_balance_plus
 * @property int $balance
 * @property int $email_warning
 * @property string $name
 * @property string $password_confirm
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        Yii::$app->formatter->defaultTimeZone = 'Europe/Kiev';
        return [
            [['username', 'phone'], 'required'],
            [['status', 'skidka', 'skidka_val', 'sending', 'total_balance_plus', 'balance', 'email_warning'], 'integer'],
            [['comment', 'admin_comment'], 'string'],
            [['username', 'password_reset_token', 'email', 'phone', 'city', 'address', 'name', 'password_confirm'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique', 'message' => 'Пользователь с таким Логином уже зарегистрирован.'],
            [['password_reset_token'], 'unique'],
            ['email', 'unique', 'message' => 'Пользователь с таким Email-ом уже зарегистрирован.'],
            
//            ['sending', 'filter', 'filter' => function($value_sending){if ($value_sending == 'Да'): return '2'; else: return '-1'; endif;}],
            
            ['updated_at', 'filter', 'filter' => function($value){return Yii::$app->formatter->asTimestamp('now');}],
            ['created_at', 'filter', 'filter' => function($value){return Yii::$app->formatter->asTimestamp($value);}],
            ['name', 'filter', 'filter' => function($value){
                if ($value == ''){
                    return '-1';
                } else {
                    return $value;
                }
                
            }], 
            
            ['password_hash', 'string', 'skipOnEmpty' => true],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
            'skidka' => 'Скидка',
            'skidka_val' => 'Размер скидки',
            'phone' => 'Телефон',
            'city' => 'Город',
            'address' => 'Адрес',
            'comment' => 'Комментарий клиента',
            'sending' => 'Рассылка',
            'admin_comment' => 'Комментарий администратора',
            'total_balance_plus' => 'Всего пополнено',
            'balance' => 'Баланс',
            'email_warning' => 'Email Warning',
            'name' => 'Имя',
            'password_confirm' => 'Password Confirm',
        ];
    }
    
    public function getOrder()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }
}
