<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\Vin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vin-view">

    <h1>Просмотр VIN-запроса <?= Html::encode($this->title) ?></h1>

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
//            'user_id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    if ($model->user_id == '-1' OR $model->user_id == '' OR $model->user_id == '0') {
                        return 'Гость';
                    } else {
                        return $model->user_id;
                    }
                }
            ],
            [
                'attribute' => 'Логин',
                'value' => function ($model) {
                    if ($model->user_id == '-1' OR $model->user_id == '' OR $model->user_id == '0') {
                        return 'Гость';
                    } else {
                        return (new Query())->select('username')->from('user')->where(['id' => $model->user_id])->limit(1)->one()['username'];
                    }
                }
            ],
            [
                'attribute' => 'Имя',
                'value' => function ($model) {
                    if ($model->user->name == '-1' OR $model->user->name == '' OR $model->user->name == '0') {
                        return '-';
                    } else {
                        return (new Query())->select('username')->from('user')->where(['id' => $model->user->name])->limit(1)->one()['username'];
                    }
                }
            ],
            'user_contacts',
            'date',
            'vin',
            'brand',
            'model',
            'year',
            'engine',
            'comment:ntext',
        ],
    ]) ?>

</div>
