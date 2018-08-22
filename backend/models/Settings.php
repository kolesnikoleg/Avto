<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $type
 * @property string $value
 * @property string $text
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['type', 'value'], 'string', 'max' => 255],
            [['type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Название',
            'value' => 'Значение',
            'text' => 'Текст',
        ];
    }
    
    public function getSettings($type)
    {
        return (new \yii\db\Query())->select(['value'])->from('settings')->where(['type' => $type])->limit(1)->one()['value'];
    }
}
