<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CartSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cart-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'product_article') ?>

    <?= $form->field($model, 'product_price_name') ?>

    <?= $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'product_count') ?>

    <?php // echo $form->field($model, 'product_info') ?>

    <?php // echo $form->field($model, 'start_cart') ?>

    <?php // echo $form->field($model, 'ident') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
