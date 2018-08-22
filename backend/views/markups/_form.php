<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Markups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markups-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $model->price_name = substr($model->price_name, 4); ?>
    <?= $form->field($model, 'price_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from')->textInput() ?>

    <?= $form->field($model, 'to')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'znak')->dropdownList(['+' => '+', '*' => '*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
