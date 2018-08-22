<?php

namespace frontend\models\user;

use Yii;
use yii\db\Query;


class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            ['address', 'trim'],
            ['address', 'default', 'value' => '-1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'address' => 'АДРЕС ДОСТАВКИ ПО-УМОЛЧАНИЮ',
        ];
    }
    
    public function getEmptyAddress ()
    {
        if ($this->address == '-1' OR $this->address == '' OR $this->address === '0') return ''; else return $this->address;
    }
}
