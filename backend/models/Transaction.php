<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $user_id
 * @property string $math_op
 * @property string $value
 * @property string $date
 * @property int $order_id
 * @property string $admin_comment
 * @property string $comment_for_user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'math_op', 'value', 'date'], 'required'],
            [['user_id'], 'integer'],
            [['admin_comment', 'comment_for_user'], 'string'],
            [['math_op'], 'string', 'max' => 2],
            [['value', 'date'], 'string', 'max' => 45],
            
            ['order_id', 'filter', 'filter' => function($value){
                if ($value == 'Пополнение') return '-1';
            }],
            
            ['admin_comment', 'filter', 'filter' => function($value){
                if ($value == '') return '-1';
            }],
            
            ['comment_for_user', 'filter', 'filter' => function($value){
                if ($value == '') return '-1';
            }],
                    
            ['admin', 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Клиент',
            'math_op' => 'Операция',
            'value' => 'Значение',
            'date' => 'Дата',
            'order_id' => 'Заказ',
            'admin_comment' => 'Комментарий админа',
            'comment_for_user' => 'Коммментарий для клиента',
            'admin' => 'Админ',
            
            'username' => 'Логин',
            'name' => 'Имя',
            
            'createdFrom' => 'Дата "ОТ"',
            'createdTo' => 'Дата "ДО"',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
