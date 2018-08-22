<?php

namespace frontend\models;

use Yii;
use yii\db\Query;

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
            [['id', 'text'], 'required'],
            [['id'], 'integer'],
            [['text', 'text_color', 'bg_color'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'text_color' => 'Text Color',
            'bg_color' => 'Bg Color',
        ];
    }
    
    public function getOrder()
    {
        return $this->hasMany(Order::className(), ['status' => 'id']);
    }
    
    public function getStatusById ($id)
    {
        return self::findOne(['id' => $id]);
    }
    
    public function getAllStatuses()
    {
        return (new Query())->select(['id', 'text'])
                ->from('status')
                ->all();
    }
}
