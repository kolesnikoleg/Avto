<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'РЕГИСТРАЦИЯ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="row">
        
        
         <section>
		
			<div class="container">
				
				<!--<form action="#" class="myform">-->
                                     <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'myform'],]); ?>
                                
                                        <p class="head"><?= Html::encode($this->title) ?></p>
                                        
                                        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин <span class="red">*</span>') ?>
                                        
                                        <?= $form->field($model, 'password')->passwordInput()->label('Пароль <span class="red">*</span>') ?>
                                        
                                        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'ПРИМЕР: 0971234567'])->label('Мобильный телефон (СТРОГО - 0XXYYYYYYY) <span class="red">*</span>') ?>
                                        
                                        <?= $form->field($model, 'email')->label('Email') ?>
                                        
                                        <?= $form->field($model, 'name')->textInput()->label('Ф.И.О.') ?>
                                        
                                        <?= $form->field($model, 'city')->textInput()->label('Город') ?>
                                        
                                        <?= $form->field($model, 'address')->textInput()->label('Адрес доставки по-умолчанию') ?>
                                        
                                     
                                        
                                        <?= $form->field($model, 'balance')->checkbox(['checked' => false, 'required' => true])->label('Я согласен с <a href="/offerta" target="_blank">Публичной офертой</a> <span class="red">*</span>'); ?>
                    
                                        
                                        <?= Html::submitButton('ЗАРЕГИСТРИРОВАТЬСЯ', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                                        
				<?php ActiveForm::end(); ?>
			</div>
		
	</section>
        
    </div>
</div>
