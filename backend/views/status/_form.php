<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Status */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?php $model->text_color = '#' . $model->text_color ?>
    <?= $form->field($model, 'text_color')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Выберите цвет', 'readonly' => true],
    ]);?>

    <?php $model->bg_color = '#' . $model->bg_color ?>
    <?= $form->field($model, 'bg_color')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Выберите цвет', 'readonly' => true],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
