<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use frontend\models\Settings;

/**
 * This is the model class for table "markups".
 *
 * @property int $id
 * @property string $price_name
 * @property string $from
 * @property string $to
 * @property string $value
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
            [['price_name'], 'string', 'max' => 255],
            [['from', 'to', 'value', 'znak'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_name' => 'Price Name',
            'from' => 'From',
            'to' => 'To',
            'value' => 'Value',
            'znak' => 'Znak',
        ];
    }
    
    public function getMarkupVal ($price, $val)
    {
        $m_settings = new Settings();
        $res = (new \yii\db\Query())
            ->select(['value'])
            ->from('markups')
            ->where(['price_name' => $price])
            ->andWhere(['<=', 'from', $val])
            ->andWhere(['>=', 'to', $val])
            ->one()['value'];
        if (!$res) return $m_settings->getDefaultMarkup(); else return $res;
           return Yii::$app->db->createCommand('SELECT value FROM markups WHERE price_name = '.$price.' AND from <= '.$val.' AND to > '.$val)->queryOne()['value'];
    }
    
    public function getMarkupZnak ($price, $val)
    {
        $m_settings = new Settings();
        $res = (new \yii\db\Query())
            ->select(['znak'])
            ->from('markups')
            ->where(['price_name' => $price])
            ->andWhere(['<=', 'from', $val])
            ->andWhere(['>=', 'to', $val])
            ->one()['znak'];
        return $res;
    }
}
