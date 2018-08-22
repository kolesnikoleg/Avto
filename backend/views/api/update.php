<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Api */

$this->title = 'Update Api: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="api-update">

    <h1>Изменить API <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
