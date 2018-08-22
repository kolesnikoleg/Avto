<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'type',
            [
                'attribute' => 'value',
                'value' => function ($model) {
                    if ($model->value == '-1' OR $model->value == null OR is_null($model->value)) {
                        return '-';
                    } else {
                        return $model->value;
                    }
                },
                'format' => 'text'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}  {update}',
            ],
        ],
    ]); ?>
</div>
