<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Api */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-view">

    <h1>Просмотр API <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'address',
            'login',
            'password',
            'currency',
            'name',
            'min_order',
        ],
    ]) ?>

</div>
