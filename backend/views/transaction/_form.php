<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'math_op')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'value')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'date')->textInput(['readonly' => 'readonly']) ?>
    
    <?= $form->field($model, 'admin')->textInput(['readonly' => 'readonly']) ?>
    
    <?php
    if ($model->order_id == '-1'): $model->order_id = 'Пополнение'; endif;
    ?>
    <?= $form->field($model, 'order_id')->textInput(['readonly' => 'readonly']) ?>

    <?php
    if ($model->admin_comment == '-1'): $model->admin_comment = ''; endif;
    ?>
    <?= $form->field($model, 'admin_comment')->textarea(['rows' => 6]) ?>

    <?php
    if ($model->comment_for_user == '-1'): $model->comment_for_user = ''; endif;
    ?>
    <?= $form->field($model, 'comment_for_user')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
