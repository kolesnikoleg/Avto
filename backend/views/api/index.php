<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchApi */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'API';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Api', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'address',
            'login',
            'password',
            'currency',
            //'name',
            //'min_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
