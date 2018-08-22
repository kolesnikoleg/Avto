<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1>Просмотр клиента <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить этого клиента?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
//            'status',
//            'created_at',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
                }
            ],
//            'updated_at',
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d.m.Y H:i:s');
                }
            ],
//            'skidka',
            [
                'attribute' => 'skidka',
                'value' => function ($model) {
                    if ($model->skidka == '-1' OR $model->skidka == '' OR $model->skidka == '0') {
                        return 'Нет';
                    } else {
                        return 'Да';
                    }
                }
            ],
//            'skidka_val',
            [
                'attribute' => 'skidka_val',
                'value' => function ($model) {
                    if ($model->skidka_val == '-1' OR $model->skidka_val == '') {
                        return '-';
                    } else {
                        return $model->skidka_val;
                    }
                }
            ],
            'phone',
//            'city',
            [
                'attribute' => 'city',
                'value' => function ($model) {
                    if ($model->city == '-1' OR $model->city == '') {
                        return '-';
                    } else {
                        return $model->city;
                    }
                }
            ],
//            'address',
            [
                'attribute' => 'address',
                'value' => function ($model) {
                    if ($model->address == '-1' OR $model->address == '') {
                        return '-';
                    } else {
                        return $model->address;
                    }
                }
            ],
//            'comment:ntext',
            [
                'attribute' => 'comment',
                'format' => 'ntext',
                'value' => function ($model) {
                    if ($model->comment == '-1' OR $model->comment == '') {
                        return '-';
                    } else {
                        return $model->comment;
                    }
                }
            ],
//            'sending',
            [
                'attribute' => 'sending',
                'value' => function ($model) {
                    if ($model->sending == '-1' OR $model->sending == '') {
                        return 'Нет';
                    } else {
                        return 'Да';
                    }
                }
            ],
//            'admin_comment:ntext',
            [
                'attribute' => 'admin_comment',
                'format' => 'ntext',
                'value' => function ($model) {
                    if ($model->admin_comment == '-1' OR $model->admin_comment == '') {
                        return '-';
                    } else {
                        return $model->admin_comment;
                    }
                }
            ],
            'total_balance_plus',
            'balance',
//            'email_warning:email',
//            'name',
            [
                'attribute' => 'name',
                'value' => function ($model) {
                    if ($model->name == '-1' OR $model->name == '') {
                        return '-';
                    } else {
                        return $model->name;
                    }
                }
            ],
//            'password_confirm',
        ],
    ]) ?>

</div>
