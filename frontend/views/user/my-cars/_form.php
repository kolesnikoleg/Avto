<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\user\MyCars */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="my-cars-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'myform']]); ?>

    <?= $form->field($model, 'vin')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'brand')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'kpp')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'engine')->textInput(['maxlength' => true, 'placeholder' => 'Не указано!']) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'placeholder' => 'Не указано!']) ?>

    <?php
    if (Yii::$app->session->getFlash('success')):
        echo '<p class="flash green">'.Yii::$app->session->getFlash("success").'</p>';
    endif;
    if (Yii::$app->session->getFlash('error')):
        foreach (Yii::$app->session->getFlash('error') as $key => $value)
        {
             if (is_array($value)):
                 echo '<p class="flash red">'.$value[0].'</p>';
             else:
                 echo '<p class="flash red">'.$value.'</p>';
             endif;
        }

    endif;
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('СОХРАНИТЬ', ['class' => 'btn_us']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
