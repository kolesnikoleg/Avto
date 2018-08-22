<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

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

    <div class="form-group">
        <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
