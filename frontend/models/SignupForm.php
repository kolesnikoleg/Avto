<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use frontend\models\Settings;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone;
    public $city;
    public $address;
    public $balance;
    public $name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $settings_req = new Settings();
        if ($settings_req->getStatusCityRequire()): $city_req = 'required'; else: $city_req = 'trim'; endif;
        if ($settings_req->getStatusEmailRequire()): $email_req = 'required'; else: $email_req = 'trim'; endif;
        
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Небходимо ввести Логин.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким Логином уже зарегистрирован.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким Email-ом уже зарегистрирован.'],

            ['password', 'required', 'message' => 'Небходимо ввести пароль.'],
            ['password', 'string', 'min' => 3],
            
            ['phone', 'trim'],
            ['phone', 'required', 'message' => 'Небходимо ввести номер телефона.'],
            ['phone', 'integer'],
            ['phone', 'string', 'max' => 10],
            ['phone', 'string', 'min' => 10],
            
            ['city', 'trim'],
            ['city', 'string', 'max' => 255],
            
            ['address', 'trim'],
            ['address', 'string', 'max' => 255],
            
            ['name', 'trim'],
            ['name', 'string', 'max' => 255],
            
            ['balance', 'required', 'on'=>'LicenseAgreement', 'message'=>''],
            
            ['city', $city_req], 
            ['email', $email_req], 


        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'ЛОГИН',
            'password' => 'ПАРОЛЬ',
            'phone' => 'ТЕЛЕФОН',
            'city' => 'ГОРОД',
            'email' => 'EMAIL',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->phone = $this->phone;
        $user->city = $this->city;
        $user->address = $this->address;
        $user->name = $this->name;
        $user->balance = 0;
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
