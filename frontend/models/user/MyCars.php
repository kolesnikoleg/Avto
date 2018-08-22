<?php

namespace frontend\models\user;

use Yii;

/**
 * This is the model class for table "my_cars".
 *
 * @property int $id
 * @property int $user_id
 * @property string $vin
 * @property string $brand
 * @property string $model
 * @property string $year
 * @property string $kpp
 * @property string $engine
 * @property string $comment
 */
class MyCars extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vin'], 'required'],
            [['user_id'], 'integer'],
            ['user_id', 'default', 'value' => '777'],
            [['comment'], 'string'],
            [['vin', 'brand', 'model', 'year', 'kpp', 'engine'], 'string', 'max' => 255],
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
            'vin' => 'VIN',
            'brand' => 'Бренд',
            'model' => 'Модель',
            'year' => 'Год выпуска',
            'kpp' => 'КПП',
            'engine' => 'Двигатель',
            'comment' => 'Комментарий',
        ];
    }
}
