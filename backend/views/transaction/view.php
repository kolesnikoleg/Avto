<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\Transaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">

    <h1>Просмотр транзакции <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'math_op',
            'value',
            'date',
            [
                'attribute' => 'order_id',
                'value' => function ($model) {
                    if ($model->order_id == '-1') {
                        return 'Пополнение';
                    } else {
                        return $model->order_id;
                    }
                }
            ],
            [
                'attribute' => 'admin_comment',
                'value' => function ($model) {
                    if ($model->admin_comment == '-1') {
                        return 'Нет';
                    } else {
                        return $model->admin_comment;
                    }
                }
            ],
            [
                'attribute' => 'comment_for_user',
                'value' => function ($model) {
                    if ($model->comment_for_user == '-1') {
                        return 'Нет';
                    } else {
                        return $model->comment_for_user;
                    }
                }
            ],
        ],
    ]) ?>

</div>
