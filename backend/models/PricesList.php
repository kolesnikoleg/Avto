<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prices_list".
 *
 * @property int $id
 * @property string $name
 * @property string $term
 * @property string $currency
 * @property string $date
 * @property int $rows
 */
class PricesList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'term', 'currency'], 'required'],
            [['rows'], 'integer'],
            [['name'], 'unique'],
            [['name', 'term', 'date'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 45],
            [['rows_now'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'term' => 'Срок',
            'currency' => 'Валюта',
            'rows' => 'Строк должно быть',
            'rows_now' => 'Строк по факту',
            'date' => 'Дата',
        ];
    }
}
