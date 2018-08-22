<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <?= $form->field($model, 'createdFrom')->widget(
        DatePicker::className(), [
            'language' => 'ru',
            'options' => ['autocomplete' => 'off'],
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]); ?>

    <?= $form->field($model, 'createdTo')->widget(
        DatePicker::className(), [
            'language' => 'ru',
            'options' => ['autocomplete' => 'off'],
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);  ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'admin_status') ?>

    <?php // echo $form->field($model, 'date_status') ?>

    <?php // echo $form->field($model, 'client_comment') ?>

    <?php // echo $form->field($model, 'admin_comment') ?>

    <?php // echo $form->field($model, 'date_admin_comment') ?>

    <?php // echo $form->field($model, 'who_admin_comment') ?>

    <?php // echo $form->field($model, 'admin_archive') ?>

    <?php // echo $form->field($model, 'user_archive') ?>

    <?php // echo $form->field($model, 'date_changed') ?>

    <?php // echo $form->field($model, 'who_admin_changed') ?>

    <?php // echo $form->field($model, 'user_delete') ?>

    <div class="form-group">
        <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
