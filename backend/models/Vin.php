<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vin".
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_contacts
 * @property string $vin
 * @property string $brand
 * @property string $model
 * @property string $year
 * @property string $engine
 * @property string $comment
 */
class Vin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['comment', 'date'], 'safe'],
            [['comment'], 'string'],
            [['user_contacts', 'brand', 'model'], 'string', 'max' => 255],
            [['vin', 'engine'], 'string', 'max' => 45],
            [['year'], 'string', 'max' => 10],
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
            'user_contacts' => 'Контакты клиента',
            'vin' => 'VIN',
            'brand' => 'Бренд',
            'model' => 'Модель',
            'year' => 'Год',
            'engine' => 'Двигатель',
            'comment' => 'Комментарий',
            'date' => 'Дата',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
