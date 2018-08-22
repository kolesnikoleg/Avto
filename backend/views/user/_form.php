<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use janisto\timepicker\TimePicker;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?php 
    $model->created_at = Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
    echo $form->field($model, 'created_at')->widget(\janisto\timepicker\TimePicker::className(), [
        'language' => 'ru',
        'mode' => 'datetime',
        'clientOptions' => [
//            'dateFormat' => 'yy-mm-dd',
//            'timeFormat' => 'HH:mm:ss',
            'dateFormat' => 'dd.mm.yy',
            'timeFormat' => 'HH:mm:ss',
            'showSecond' => true,
        ]
    ]);
    ?>

    <?php
    $model->updated_at = Yii::$app->formatter->asDatetime($model->updated_at, 'php:d.m.Y H:i:s');
    ?>
    <?= $form->field($model, 'updated_at')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'skidka')->dropdownList(['0' => 'Нет', '2' => 'Да']) ?>

    <?= $form->field($model, 'skidka_val')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'sending')->dropdownList(['-1' => 'Нет', '2' => 'Да']) ?>

    <?= $form->field($model, 'admin_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'total_balance_plus')->textInput() ?>

    <?= $form->field($model, 'balance')->textInput() ?>

    <?php
    if ($model->name == '-1'): $model->name = ''; endif;
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

