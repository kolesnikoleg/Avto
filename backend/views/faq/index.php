<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FAQ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'question',
                'contentOptions' => ['class' => 'swn'],
                'value' => 'question',
            ],
            [
                'attribute' => 'answer',
                'contentOptions' => ['class' => 'swn'],
                'value' => 'answer',
            ],
            'order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
