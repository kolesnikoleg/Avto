<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Settings;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Корзины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            [
                'label' => 'Логин',
                'attribute' => 'username',
                'value'=>function ($data) {
                    return Html::a($data->user->username, ['/user?UserSearch[username]=' . $data->user->username]);
                },
                'format' => 'raw'
            ],
            [
                'label' => 'Имя',
                'attribute' => 'name',
//                'value' => 'user.name',
                'value' => function ($model) {
                    if ($model->user->name == '-1') {
                        return '-';
                    } else {
                        return $model->user->name;
                    }
                    
//                    return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s');
                },
                'format' => 'text'
            ],
            [
                'attribute' => 'products',
                'format' => 'html',
                'value' => function ($model) {
                
                    $product = json_decode($model->product_info, true);
                    
                    $str = '';
                    
                    $str .= '<table class="view_order_products">';
                        $str .= '<tr class="head">';
                            $str .= '<td>Название</td>';
                            $str .= '<td>Вес</td>';
                            $str .= '<td>Срок</td>';
                            $str .= '<td>Мин.заказ</td>';
                            $str .= '<td>Валюта</td>';
                            $str .= '<td>Производитель</td>';
                            $str .= '<td>Цена</td>';
                            $str .= '<td>Количество</td>';
                            $str .= '<td>Сумма</td>';
                            $str .= '<td>Артикул</td>';
                            $str .= '<td>Прайс</td>';
                        $str .= '</tr>';
                        
                        $str .= '<tr>';
                            $str .= '<td>' . $product['name'] . '</td>';
                            $str .= '<td>' . $product['weight'] . '</td>';
                            $str .= '<td>' . $product['term'] . '</td>';
                            $str .= '<td>' . $product['min_order'] . '</td>';
                            $str .= '<td>' . $product['currency'] . '</td>';
                            $str .= '<td>' . $product['manufacturer'] . '</td>';
                            $str .= '<td>' . $product['price'] . '</td>';
                            $str .= '<td>' . $model->product_count . '</td>';
                            $str .= '<td>' . $product['price'] * $model->product_count . '</td>';
                            $str .= '<td>' . $product['article'] . '</td>';

                            if (substr($product['this_price_name'], 0, 4) == (new Settings())->getPricelistsPrefix()) {                            
                                $str .= '<td>' . substr($product['this_price_name'], 4) . '</td>';
                            }
                            else
                            {
                                $str .= '<td>' . $product['this_price_name'] . '</td>';
                            }
                        $str .= '</tr>';
                    $str .= '</table>';
                        
                    return $str;
                }
            ],
//            'product_article',
//            'product_price_name',
//            'product_id',
            'product_count',
            //'product_info:ntext',
//            'start_cart',
            [
                'attribute' => 'start_cart',
                'value' => function ($model) {
                    return $model->start_cart;
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'language' => 'ru',
                    'attribute' => 'start_cart',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])   
            ],
            //'ident',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
