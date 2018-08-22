<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property int $readed
 * @property string $date
 * @property int $admin
 * @property string $text
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'readed', 'admin'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['username', 'name'], 'safe'],
            
            ['readed', 'filter', 'filter' => function($value){
                return -1;
            }],
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
            'username' => 'Логин',
            'name' => 'Имя',
            'readed' => 'Прочитано',
            'date' => 'Дата',
            'admin' => 'Админ',
            'text' => 'Текст',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
