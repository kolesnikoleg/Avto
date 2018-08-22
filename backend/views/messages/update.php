<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Messages */

$this->title = 'Изменить сообщение ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Сохранить';
?>
<div class="messages-update">

    <h1>Изменить сообщение <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
