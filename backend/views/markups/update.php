<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Markups */

$this->title = 'Изменить наценку ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Markups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="markups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
