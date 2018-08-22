<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сообщение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'value' => function ($model) {
                    if ($model->user->name == '-1') {
                        return '-';
                    } else {
                        return $model->user->name;
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Прочитано',
                'attribute' => 'readed',
                'value' => function ($model) {
                    if ($model->readed == '-1') {
                        return 'Нет';
                    } else {
                        return 'Да';
                    }
                },
                'format' => 'text'
            ],
            'date',
            [
                'label' => 'Админ',
                'attribute' => 'admin',
                'value' => function ($model) {
                    if ($model->admin == '0') {
                        return 'Оплата';
                    } else {
                        if ($model->admin == '-1') {
                            return '-';
                        } else {
                            return (new Query())->select(['username'])->from('admin')->where(['id' => $model->admin])->limit(1)->one()['username'];
                        }
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Текст',
                'attribute' => 'text',
                'contentOptions' => ['class' => 'swn'],
            ],
                
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
