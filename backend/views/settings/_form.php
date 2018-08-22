<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['readonly' => 'readonly']) ?>

    <?php 
    if ($model->type == 'jivosite') {
        echo $form->field($model, 'value')->dropdownList(['Включен' => 'Включен', 'Выключен' => 'Выключен']);
    } else {
        if ($model->type == 'city_require' OR $model->type == 'email_require') {
            echo $form->field($model, 'value')->dropdownList(['Да' => 'Да', 'Нет' => 'Нет']);
        } else {        
            echo $form->field($model, 'value')->textInput(['maxlength' => true]);
        }
    } ?>

    <?php /* $form->field($model, 'text')->textarea(['rows' => 6]) */ ?>
    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'preset' => 'full'
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
