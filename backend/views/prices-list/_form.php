<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PricesList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prices-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'term')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->dropdownList(['USD' => 'USD', 'EURO' => 'EURO', 'UAH' => 'UAH']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
