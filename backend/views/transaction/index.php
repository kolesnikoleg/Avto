<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Транзакции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            [
                'label' => 'Логин',
                'attribute' => 'username',
                'value' => 'user.username',
                'format' => 'text'
            ],
            [
                'label' => 'Имя',
                'attribute' => 'name',
//                'value' => 'user.name',
                'value' => function ($model) {
                    if ($model->user->name == '-1') {
                        return '-';
                    } else {
                        return $model->user->name;
                    }
                },
                'format' => 'text'
            ],
            'math_op',
            'value',
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
                        'format' => 'yyyy-mm-dd'
                    ]
                ])   
            ],
            //'order_id',
            //'admin_comment:ntext',
//            'comment_for_user:ntext',
            [
                'attribute' => 'comment_for_user',
                'value' => function ($model) {
                    if ($model->comment_for_user == '-1') {
                        return '-';
                    } else {
                        return $model->comment_for_user;
                    }
                },
                'format' => 'ntext'
            ],
            'admin',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}'
            ],
        ],
    ]); ?>
</div>
