<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Vin */

$this->title = 'Create Vin';
$this->params['breadcrumbs'][] = ['label' => 'Vins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
