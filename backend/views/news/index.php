<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'label' => 'Текст новости',
                'attribute' => 'content',
                'contentOptions' => ['class' => 'swn'],
                'value' => 'content',
                'format' => 'html'
            ],
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == '1') {
                        return 'Опубликовано';
                    } else {
                        return 'Скрыто';
                    } 
                },
                'filter' => ['1' => 'Опубликованные', '-1' => 'Спрятанные'],
                'filterInputOptions' => ['prompt' => 'Все'],
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
                        'format' => 'dd.mm.yyyy'
                    ]
                ])   
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
