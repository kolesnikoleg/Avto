<?php

namespace frontend\models;

use Yii;

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
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
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
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'phone'], 'required'],
            [['status', 'created_at', 'updated_at', 'skidka', 'skidka_val', 'sending', 'total_balance_plus', 'balance', 'email_warning'], 'integer'],
            [['comment', 'admin_comment'], 'string'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'phone', 'city', 'address'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'skidka' => 'Skidka',
            'skidka_val' => 'Skidka Val',
            'phone' => 'Phone',
            'city' => 'City',
            'address' => 'Address',
            'comment' => 'Comment',
            'sending' => 'Sending',
            'admin_comment' => 'Admin Comment',
            'total_balance_plus' => 'Total Balance Plus',
            'balance' => 'Balance',
            'email_warning' => 'Email Warning',
        ];
    }
    
    public function getFieldByIdUser ($id_user, $field)
    {
        return self::find()->where(['id' => $id_user])->one()[$field];
    }
}
