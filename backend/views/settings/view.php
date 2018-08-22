<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Settings */

$this->title = $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-view">

    <h1>Просмотр настройки <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'attribute' => 'text',
                'value' => function ($model) {
                    if ($model->text == '-1' OR $model->text == null OR is_null($model->text)) {
                        return '-';
                    } else {
                        return $model->text;
                    }
                },
                'format' => 'ntext'
            ],
        ],
    ]) ?>

</div>
