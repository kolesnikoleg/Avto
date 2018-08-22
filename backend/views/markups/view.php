<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Markups */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Markups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markups-view">

    <h1>Просмотр наценки <?= Html::encode($this->title) ?></h1>

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
        ],
    ]) ?>

</div>
