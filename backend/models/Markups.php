<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "markups".
 *
 * @property int $id
 * @property string $price_name
 * @property int $from
 * @property int $to
 * @property int $value
 * @property string $znak
 */
class Markups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_name', 'from', 'to', 'value', 'znak'], 'required'],
            [['from', 'to', 'value'], 'integer'],
            [['price_name', 'znak'], 'string', 'max' => 255],
            
            ['price_name', 'filter', 'filter' => function($value){
                return 'prc_' . $value;
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
            'price_name' => 'Название',
            'from' => 'От',
            'to' => 'До',
            'value' => 'Значение',
            'znak' => 'Знак',
        ];
    }
}
