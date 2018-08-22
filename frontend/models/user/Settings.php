<?php

namespace frontend\models\user;

use Yii;
use yii\db\Query;


class Settings extends \yii\db\ActiveRecord
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
        return [
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'default', 'value' => '-1'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'Пользователь с таким Email-ом уже зарегистрирован.'],
            
            ['phone', 'trim'],
            ['phone', 'required', 'message' => 'Поле "Телефон" обязательно.'],
            
            ['name', 'trim'],
            ['name', 'default', 'value' => '-1'],
            
            ['city', 'trim'],
            ['city', 'default', 'value' => '-1'],
            
            ['address', 'trim'],
            ['address', 'default', 'value' => '-1'],
            
            ['comment', 'trim'],
            ['comment', 'default', 'value' => '-1'],
            
//            ['password_hash', 'trim'],
//            ['password_hash', 'compare', 'compareAttribute' => 'password_confirm'],
//            
//            ['password_confirm', 'trim']
            
            ['password_hash', 'string', 'skipOnEmpty' => true],
            ['password_hash', 'compare', 'compareAttribute' => 'password_confirm', 'message' => 'Пароли не совпадают!'],
            
            
            ['password_confirm', 'string', 'skipOnEmpty' => true],
//            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'НОВЫЙ ПАРОЛЬ',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'skidka' => 'Skidka',
            'skidka_val' => 'Skidka Val',
            'phone' => 'Мобильный телефон',
            'city' => 'Город',
            'address' => 'АДРЕС ДОСТАВКИ ПО-УМОЛЧАНИЮ',
            'comment' => 'Комментарий',
            'sending' => 'Sending',
            'admin_comment' => 'Admin Comment',
            'total_balance_plus' => 'Total Balance Plus',
            'balance' => 'Balance',
            'email_warning' => 'Email Warning',
            'name' => 'Имя',
            'password_confirm' => 'Подтвердите пароль',
        ];
    }
    
    public function getCreatedDate ()
    {
        return date('d.m.Y', $this->created_at);
    }
    
    public function getEmptyEmail ()
    {
        if ($this->email == '-1') return ''; else return $this->email;
    }
    
    public function getEmptyName ()
    {
        if ($this->name == '-1') return ''; else return $this->name;
    }
    
    public function getEmptyCity ()
    {
        if ($this->city == '-1') return ''; else return $this->city;
    }
    
    public function getEmptyAddress ()
    {
        if ($this->address == '-1') return ''; else return $this->address;
    }
    
    public function getEmptyComment ()
    {
        if ($this->comment == '-1') return ''; else return $this->comment;
    }
}
