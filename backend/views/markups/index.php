<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MarkupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Наценки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markups-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать наценку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'price_name',
                'value' => function ($model) {
                    return substr($model->price_name, 4);
                }
            ],
            'from',
            'to',
            'value',
            'znak',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
