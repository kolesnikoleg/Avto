<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'VIN-запросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vin-index">

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
//            'user_id',
            [
//                'label' => 'Логин',
                'attribute' => 'user_id',
//                'value' => 'user.username',
                'value' => function ($model) {
                    if ($model->user_id == '-1') {
                        return 'Гость';
                    } else {
                        return $model->user_id;
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Логин',
                'attribute' => 'username',
//                'value' => 'user.username',
                'value' => function ($model) {
                    if ($model->user_id == '-1') {
                        return 'Гость';
                    } else {
                        return $model->user->username;
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Имя',
                'attribute' => 'name',
                'value' => function ($model) {
                    if ($model->user_id == '-1') {
                        return 'Гость';
                    } else {
                        if ($model->user->name == '-1') {
                            return '-';
                        } else {
                            return $model->user->name;
                        }
                    }
                },
                'format' => 'text'
            ],
            'user_contacts',
            'vin',
            'brand',
            'model',
//            'year',
            //'engine',
            'comment:ntext',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
