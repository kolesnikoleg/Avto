<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VinSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'user_contacts') ?>

    <?= $form->field($model, 'vin') ?>

    <?= $form->field($model, 'brand') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'engine') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
