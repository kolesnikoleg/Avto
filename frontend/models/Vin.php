<?php

namespace frontend\models;

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
            ['vin', 'required'],
            ['user_contacts', 'required', 'message' => 'Напишите, как Вам ответить'],
            [['brand', 'model'], 'string', 'max' => 255],
            [['vin', 'engine'], 'string', 'max' => 45],
            ['brand', 'default', 'value' => '-1'],
            ['model', 'default', 'value' => '-1'],
            ['year', 'default', 'value' => '-1'],
            ['engine', 'default', 'value' => '-1'],
            ['comment', 'default', 'value' => '-1'],
            [['vin'], 'string', 'min' => 6, 'message' => 'VIN-номер не может быть меньше 6 символов'],
            ['date', 'filter', 'filter' => function($value){
                return Yii::$app->formatter->asDatetime('now', "php:Y-m-d H:i:s");
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
            'user_id' => 'User ID',
            'user_contacts' => 'User Contacts',
            'vin' => 'VIN',
            'brand' => 'Производитель',
            'model' => 'Модель',
            'year' => 'Год выпуска',
            'engine' => 'Двигатель',
            'comment' => 'Комментарий',
            'date' => 'Дата',
        ];
    }
}
