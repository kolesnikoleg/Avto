<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\i18n\Formatter;
use frontend\models\Settings;
use frontend\models\Status;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    
    

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
    
    <?php
    
    $orders = $dataProvider->query->all();

    $total_price = 0;
    foreach ($orders as $order) {
        $buf = json_decode($order['products'], true);
        $total_price += $buf['total_price'];
    }
    ?>
    
    <p>Общая сумма: <span class="bold"><?= $total_price ?></span> грн</p>
    
    <?php
    $buf = (new Status())->getAllStatuses();
    foreach($buf as $value) {
        $my_arr[$value['id']] = $value['text'];
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

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
                'value' => function ($model) {
                    if ($model->user->name == '-1') {
                        return '-';
                    } else {
                        return $model->user->name;
                    }
                },
                'format' => 'text'
            ],
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return $model->date;
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'language' => 'ru',
                    'attribute' => 'date',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])   
            ],
            [
                'attribute' => 'Стоимость доставки',
                'value' => function ($model) {
                    $products = json_decode($model->products, true);
                    return $products['dostavka_val'];
                }
            ],
            [
                'attribute' => 'products',
                'format' => 'html',
                'value' => function ($model) {
                
                    $products = json_decode($model->products, true);
                    
                    $str = '';
                    
                    foreach ($products as $key => $product)
                    {
                        if ($key !== "total_price" AND $key !== "total_payed" AND $key !== "dostavka_val") {
                            $str .= $key . '. <span class="bold">';
                            $str .= $product['name'] . '</span> (';
                            $str .= $product['article'] . ', ';
                            
                            if (substr($product['price_list'], 0, 4) == (new Settings())->getPricelistsPrefix()) {                            
                                $str .= substr($product['price_list'], 4) . ')';
                            }
                            else
                            {
                                $str .= $product['price_list'] . ')';
                            }

                            $str .= '<br>';
                        }
                    }
                    
                    return substr($str, 0, -4);
                }
            ],
            [
                'attribute' => 'Сумма заказа',
                'value' => function ($model) {
                    $products = json_decode($model->products, true);
                    return $products['total_price'];
                }
            ],
            [
                'attribute' => 'phone',
                'value' => function ($model) {
                    if ($model->phone == '-1' OR $model->phone == '') {
                        return '-';
                    } else {
                        return $model->phone;
                    }
                }
            ],
            [
                'attribute' => 'status',
                'filter' => $my_arr,
                'contentOptions' => function ($model) {
                    $bg = (new Query())
                            ->select(['bg_color'])
                            ->from('status')
                            ->where(['id' => $model->status])
                            ->limit(1)
                            ->one()['bg_color'];
                    $text = (new Query())
                            ->select(['text_color'])
                            ->from('status')
                            ->where(['id' => $model->status])
                            ->limit(1)
                            ->one()['text_color'];
                    return ['style' => 'background-color:#' . $bg . ';color:#' . $text];
                },
                'value' => function ($model) {
                    return (new Status())->getStatusById($model->status)->text;
                },
            ],
            [   
                'label' => 'Админ',
                'attribute' => 'adm_status',
                'value' => function ($model) {
                    if ($model->admin_status == '' OR $model->admin_status == null OR $model->admin_status == '-1') {
                        return '-';
                    } else {
                        return $model->admin->username;
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Архив',
                'attribute' => 'admin_archive',
                'filter' => ['-1' => 'Нет', '2' => 'Да'],
                'filterInputOptions' => ['prompt' => 'Все'],
                'value' => function ($model) {
                    if ($model->admin_archive == '-1') {
                        return 'Нет';
                    } else {
                        return 'Да';
                    }
                },
                'format' => 'text'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

