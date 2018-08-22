<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статусы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать статус', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'text',
            'text_color',
            'bg_color',
            [
                'label' => 'Пример',
                'attribute' => 'primer',
                'value' =>  function ($model) {
                    return "<span style='background-color:#" . $model->bg_color . ";color:#" . $model->text_color . ";border:1px #000 solid;padding:7px 10px'>Пример</span>";
                },
                'format' => 'html',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
</div>
