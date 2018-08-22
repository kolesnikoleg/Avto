<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'VIN-Запрос';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page new-client">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>VIN-ЗАПРОС</h2>
                
                <p class="mes green">
                    <span class="text">Успех! Корзина была обновлена!</span>
                    <br />
                    <span class="cls">ЗАКРЫТЬ</span>
                </p>
                
                <?php
                if (Yii::$app->session->getFlash('success')):
                ?>
                    <p class="mes green" style="display:block">
                        <span class="text"><?= Yii::$app->session->getFlash('success') ?></span>
                        <br />
                        <span class="cls">ЗАКРЫТЬ</span>
                    </p>
                <?php
                endif;
                ?>
                
                <?php $form = ActiveForm::begin(['id' => 'form-settings', 'options' => ['class' => 'myform'],]); ?>
                
                    <div class="row">
                        <div class="col-sm-12"><?= $form->field($model, 'vin')->textInput(['placeholder' => 'Например: ffg8scb720v8zdo98'])->label('VIN <span class="red">*</span>') ?></div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-12"><?= $form->field($model, 'user_contacts')->textInput(['placeholder' => 'Например: 097-123-45-67'])->label('Как вам ответить? <span class="red">*</span>') ?></div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'brand')->input('text', ['placeholder' => 'Например: Toyota']) ?></div>

                        <div class="col-sm-6"><?= $form->field($model, 'model')->input('text', ['placeholder' => 'Например: Camry']) ?></div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'year')->input('text', ['placeholder' => 'Например: 2005']) ?></div>

                        <div class="col-sm-6"><?= $form->field($model, 'engine')->input('text', ['placeholder' => 'Например: 1.6']) ?></div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-12"><?= $form->field($model, 'comment')->textarea(['placeholder' => 'Например: Универсал, салон - кожа']) ?></div>
                    </div>
                
                    <?= Html::submitButton('ОТПРАВИТЬ', ['class' => 'btn btn-primary', 'name' => 'vin-button']) ?>
                                        
                <?php ActiveForm::end(); ?>
                
            </div>
        </div>
    </div>
</section>