<?php

namespace frontend\models\user;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $user_id
 * @property string $math_op
 * @property string $value
 * @property string $date
 * @property int $order_id
 * @property string $admin_comment
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'math_op', 'value', 'date', 'admin_comment'], 'required'],
            [['user_id', 'order_id'], 'integer'],
            [['admin_comment'], 'string'],
            [['math_op'], 'string', 'max' => 2],
            [['value', 'date'], 'string', 'max' => 45],
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
            'math_op' => 'Math Op',
            'value' => 'Value',
            'date' => 'Date',
            'order_id' => 'Order ID',
            'admin_comment' => 'Admin Comment',
        ];
    }
}
