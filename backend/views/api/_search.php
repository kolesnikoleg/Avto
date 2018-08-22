<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchApi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="api-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'min_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
