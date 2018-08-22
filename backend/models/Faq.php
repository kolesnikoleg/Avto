<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question', 'answer'], 'required'],
            [['answer', 'order'], 'string'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'order' => 'Порядок',
        ];
    }
}
