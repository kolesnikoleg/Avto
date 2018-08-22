<?php

namespace frontend\models\user;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property int $readed
 * @property string $date
 * @property int $admin
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
            'readed' => 'Readed',
            'date' => 'Date',
            'admin' => 'Admin',
        ];
    }
    
    public function getCountNotReadMyMessages()
    {
        return self::find()->where(['user_id' =>Yii::$app->user->identity->id, 'readed' => -1])->count();
    }
    
    public function checkOwnMessage ($id_mes)
    {
        $mes = (new Query())->from('messages')->where(['id' => $id_mes])->limit(1)->one();
        
        if ($mes['user_id'] == Yii::$app->user->identity->id) return true;
        
        return false;
    }
}
