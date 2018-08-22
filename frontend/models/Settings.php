<?php

namespace frontend\models;

use Yii;
use yii\db\Query;

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
            'type' => 'Type',
            'value' => 'Value',
            'text' => 'Text',
        ];
    }
    
    public function getCurrencyUSD()
    {
        return (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'cur_USD'])
            ->one()['value'];
    }
    
    public function getCurrencyEURO()
    {
        return (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'cur_EURO'])
            ->one()['value'];
    }
    
    public function getDefaultMarkup()
    {
        return (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'default_markup'])
            ->one()['value'];
    }
    
    public function getPageSizeOrders()
    {
        return (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'page_size_orders'])
            ->one()['value'];
    }
    
    public function getPricelistsPrefix()
    {
        return (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'pricelist_prefix'])
            ->one()['value'];
    }
    
    public function getStatusJivosite()
    {
        $result = (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'jivosite'])
            ->one()['value'];
        if ($result == 'Включен'):
            return true;
        else:
            return false;
        endif;
    }
    
    public function getStatusCityRequire()
    {
        $result = (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'city_require'])
            ->one()['value'];
        if ($result == 'Да'):
            return true;
        else:
            return false;
        endif;
    }
    
    public function getStatusEmailRequire()
    {
        $result = (new \yii\db\Query())
            ->select(['value'])
            ->from('settings')
            ->where(['type' => 'email_require'])
            ->one()['value'];
        if ($result == 'Да'):
            return true;
        else:
            return false;
        endif;
    }
}
