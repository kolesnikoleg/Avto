<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\i18n\Formatter;
use yii\db\Query;
use frontend\models\Settings;
use frontend\models\Status;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1>Просмотр заказа <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    if ($model->user_id == '-1' OR $model->user_id == '' OR $model->user_id == '0') {
                        return 'Гость';
                    } else {
                        return $model->user_id;
                    }
                }
            ],
            [
                'attribute' => 'Логин',
                'value' => function ($model) {
                    if ($model->user_id == '-1' OR $model->user_id == '' OR $model->user_id == '0') {
                        return 'Гость';
                    } else {
                        return (new Query())->select('username')->from('user')->where(['id' => $model->user_id])->limit(1)->one()['username'];
                    }
                }
            ],
//            [
//                'attribute' => 'Логин',
//                'value' => function ($model) {
//                    return $model->user->username;
//                }
//            ],
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s');
                }
            ],
            [
                'attribute' => 'Общая сумма заказа',
                'format' => 'html',
                'value' => function ($model) {
                    $products = json_decode($model->products, true);
                    return '<span class="bold">' . $products['total_price'] . '</span> грн';
                }
            ],
            [
                'attribute' => 'Стоимость доставки',
                'value' => function ($model) {
                    $products = json_decode($model->products, true);
                    $dostavka = $products['dostavka_val'];
                    return $dostavka;
                }
            ],
            [
                'attribute' => 'products',
                'format' => 'html',
                'value' => function ($model) {
                
                    $products = json_decode($model->products, true);
                    
                    $str = '';
                    
                    $str .= '<table class="view_order_products">';
                        $str .= '<tr class="head">';
                            $str .= '<td>Название</td>';
                            $str .= '<td>Вес</td>';
                            $str .= '<td>Срок</td>';
                            $str .= '<td>Мин.заказ</td>';
                            $str .= '<td>Валюта</td>';
                            $str .= '<td>Производитель</td>';
                            $str .= '<td>Количество</td>';
                            $str .= '<td>Цена</td>';
                            $str .= '<td>Сумма</td>';
                            $str .= '<td>Оплачено</td>';
                            $str .= '<td>Артикул</td>';
                            $str .= '<td>Прайс</td>';

                        $str .= '</tr>';
                        
                        foreach ($products as $key => $product)
                        {
                            if ($key !== "total_price" AND $key !== "total_payed" AND $key !== "dostavka_val") {

                                    $str .= '<tr>';
                                        $str .= '<td>' . $product['name'] . '</td>';
                                        $str .= '<td>' . $product['weight'] . '</td>';
                                        $str .= '<td>' . $product['term'] . '</td>';
                                        $str .= '<td>' . $product['min_order'] . '</td>';
                                        $str .= '<td>' . $product['currency'] . '</td>';
                                        $str .= '<td>' . $product['manufacturer'] . '</td>';
                                        $str .= '<td>' . $product['count'] . '</td>';
                                        $str .= '<td>' . $product['price'] . '</td>';
                                        $str .= '<td>' . $product['price'] * $product['count'] . '</td>';
                                        $str .= '<td>' . $product['payed'] . '</td>';
                                        $str .= '<td>' . $product['article'] . '</td>';
                                        
                                        if (substr($product['price_list'], 0, 4) == (new Settings())->getPricelistsPrefix()) {                            
                                            $str .= '<td>' . substr($product['price_list'], 4) . '</td>';
                                        }
                                        else
                                        {
                                            $str .= '<td>' . $product['price_list'] . '</td>';
                                        }
                                        
                                        

                                    $str .= '</tr>';

                            }
                        }
                    
                    $str .= '</table>';
                        
                    return $str;
                }
            ],
            [
                'attribute' => 'dostavka',
                'value' => function ($model) {
                    if ($model->dostavka == '-1' OR $model->dostavka == '' OR $model->dostavka == '0') {
                        return '-';
                    } else {
                        return $model->dostavka;
                    }
                }
                
                
            ],
            'phone',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return (new Status())->getStatusById($model->status)->text;
                }
            ],
            [
                'attribute' => 'admin_status',
                'value' => function ($model) {
                    if ($model->admin_status == '-1' OR $model->admin_status == '' OR $model->admin_status == '0') {
                        return '-';
                    } else {
                        return $model->dostavka;
                    }
                }
            ],
            [
                'attribute' => 'date_status',
                'value' => function ($model) {
                    if ($model->date_status == '-1' OR $model->date_status == '' OR $model->date_status == '0') {
                        return '-';
                    } else {
                        return $model->date_status;
                    }
                }
            ],
            [
                'attribute' => 'client_comment',
                'value' => function ($model) {
                    if ($model->client_comment == '-1' OR $model->client_comment == '' OR $model->client_comment == '0') {
                        return '-';
                    } else {
                        return $model->client_comment;
                    }
                }
            ],
            [
                'attribute' => 'admin_comment',
                'value' => function ($model) {
                    if ($model->admin_comment == '-1' OR $model->admin_comment == '' OR $model->admin_comment == '0') {
                        return '-';
                    } else {
                        return $model->admin_comment;
                    }
                }
            ],
            [
                'attribute' => 'date_admin_comment',
                'value' => function ($model) {
                    if ($model->date_admin_comment == '-1' OR $model->date_admin_comment == '' OR $model->date_admin_comment == '0') {
                        return '-';
                    } else {
                        return $model->date_admin_comment;
                    }
                }
            ],
            [
                'attribute' => 'who_admin_comment',
                'value' => function ($model) {
                    if ($model->who_admin_comment == '-1' OR $model->who_admin_comment == '' OR $model->who_admin_comment == '0') {
                        return '-';
                    } else {
                        return $model->who_admin_comment;
                    }
                }
            ],
            [
                'attribute' => 'admin_archive',
                'value' => function ($model) {
                    if ($model->admin_archive == '-1' OR $model->admin_archive == '' OR $model->admin_archive == '0') {
                        return '-';
                    } else {
                        return $model->admin_archive;
                    }
                }
            ],
            [
                'attribute' => 'user_archive',
                'value' => function ($model) {
                    if ($model->user_archive == '-1' OR $model->user_archive == '' OR $model->user_archive == '0') {
                        return '-';
                    } else {
                        return $model->user_archive;
                    }
                }
            ],
            [
                'attribute' => 'date_changed',
                'value' => function ($model) {
                    if ($model->date_changed == '-1' OR $model->date_changed == '' OR $model->date_changed == '0') {
                        return '-';
                    } else {
                        return Yii::$app->formatter->asDatetime($model->date_changed, 'php:d.m.Y H:i:s');
                    }
                }
            ],
            [
                'attribute' => 'who_admin_changed',
                'value' => function ($model) {
                    if ($model->who_admin_changed == '-1' OR $model->who_admin_changed == '' OR $model->who_admin_changed == '0') {
                        return '-';
                    } else {
                        return $model->who_admin_changed;
                    }
                }
            ],
            [
                'attribute' => 'user_delete',
                'value' => function ($model) {
                    if ($model->user_delete == '-1' OR $model->user_delete == '' OR $model->user_delete == '0') {
                        return '-';
                    } else {
                        return $model->user_delete;
                    }
                }
            ],
        ],
    ]) ?>

</div>

