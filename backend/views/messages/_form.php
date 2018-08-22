<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Messages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?php $model->date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s') ?>
    <?= $form->field($model, 'date')->textInput(['readonly' => 'readonly']) ?>

    <?php $model->admin = Yii::$app->admin->identity->id ?>
    <?= $form->field($model, 'admin')->textInput(['readonly' => 'readonly']); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
