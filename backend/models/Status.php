<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $text
 * @property string $text_color
 * @property string $bg_color
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['id'], 'integer'],
            [['text', 'text_color', 'bg_color'], 'string', 'max' => 45],
            [['id'], 'unique'],
            
            [['text_color', 'bg_color'], 'filter', 'filter' => function($value){
                return substr($value, 1);
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
            'text' => 'Название',
            'text_color' => 'Цвет текста',
            'bg_color' => 'Цвет фона',
        ];
    }
}
