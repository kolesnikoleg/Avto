<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 * @property string $products
 * @property string $dostavka
 * @property string $phone
 * @property string $status
 * @property string $admin_status
 * @property int $date_status
 * @property string $client_comment
 * @property string $admin_comment
 * @property int $date_admin_comment
 * @property string $who_admin_comment
 * @property int $admin_archive
 * @property int $user_archive
 * @property int $date_changed
 * @property string $who_admin_changed
 * @property int $user_delete
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        Yii::$app->formatter->defaultTimeZone = 'Europe/Kiev';
        return [
            [['admin_archive', 'user_archive', 'user_delete'], 'integer'],
            [['products', 'dostavka', 'client_comment', 'admin_comment'], 'string'],
            [['phone', 'status', 'admin_status', 'who_admin_comment', 'who_admin_changed'], 'string', 'max' => 255],
            
            ['date_changed', 'filter', 'filter' => function($value){return Yii::$app->formatter->asTimestamp('now');}],
            ['who_admin_changed', 'filter', 'filter' => function($value){return Yii::$app->admin->identity->username;}],
            
            ['date_status', 'filter', 'filter' => function($value){
                $old_status = (new Query())
                                ->select(['status'])
                                ->from('order')
                                ->where(['id' => $this->id])
                                ->limit(1)
                                ->one()['status'];
                
                if ($this->status == $old_status) {
                    return Yii::$app->formatter->asTimestamp($value);
                } else {
                    return Yii::$app->formatter->asTimestamp('now');
                }
            }],
            ['admin_status', 'filter', 'filter' => function($value){
                $old_status = (new Query())
                                ->select(['status'])
                                ->from('order')
                                ->where(['id' => $this->id])
                                ->limit(1)
                                ->one()['status'];
                
                if ($this->status == $old_status) {
                    if ($value == '-1') {
                        return $value;
                    } else {
                        $id = (new Query())
                                    ->select(['id'])
                                    ->from('admin')
                                    ->where(['username' => $value])
                                    ->limit(1)
                                    ->one()['id'];
                        return $id;
                    }
                } else {
                    return Yii::$app->admin->identity->id;
                }
            }],
            
            ['date_admin_comment', 'filter', 'filter' => function($value){
                $old_comment = (new Query())
                                ->select(['admin_comment'])
                                ->from('order')
                                ->where(['id' => $this->id])
                                ->limit(1)
                                ->one()['admin_comment'];
                
                if ($this->admin_comment == $old_comment) {
                    return Yii::$app->formatter->asTimestamp($value);
                } else {
                    return Yii::$app->formatter->asTimestamp('now');
                }
            }],
            ['who_admin_comment', 'filter', 'filter' => function($value){
                $old_comment = (new Query())
                                ->select(['admin_comment'])
                                ->from('order')
                                ->where(['id' => $this->id])
                                ->limit(1)
                                ->one()['admin_comment'];
                
                if ($this->admin_comment == $old_comment) {
                    if ($value == '-1') {
                        return $value;
                    } else {
                        $id = (new Query())
                                    ->select(['id'])
                                    ->from('admin')
                                    ->where(['username' => $value])
                                    ->limit(1)
                                    ->one()['id'];
                        return $id;
                    }
                } else {
                    return Yii::$app->admin->identity->id;
                }
            }],
                    
//            ['admin_status', 'filter', 'filter' => function($value){return Yii::$app->admin->identity->username;}],
            
            ['user_id', 'filter', 'filter' => function($value){
                if ($value == '' OR $value == 'Гость'):
                    return '-1';
                else:
                    return $value;
                endif;
            }],
                    
            ['admin_comment', 'filter', 'filter' => function($value){
                if ($value == ''):
                    return -1;
                else:
                    return $value;
                endif;
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
            'user_id' => 'Клиент',
            'date' => 'Дата создания',
            'products' => 'Товары',
            'dostavka' => 'Способ доставки',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'admin_status' => 'Логин админа статуса',
            'date_status' => 'Дата изменения статуса',
            'client_comment' => 'Комментарий клиента',
            'admin_comment' => 'Комментарий админа',
            'date_admin_comment' => 'Дата комментария админа',
            'who_admin_comment' => 'Логин админа комментария',
            'admin_archive' => 'Архив для админа',
            'user_archive' => 'Архив для клиента',
            'date_changed' => 'Дата изменения',
            'who_admin_changed' => 'Логин админа изменения',
            'user_delete' => 'Удалено у клиента',
            
            'username' => 'Логин',
            'name' => 'Имя',
            
            'createdFrom' => 'Дата "ОТ"',
            'createdTo' => 'Дата "ДО"',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_status']);
    }
}
