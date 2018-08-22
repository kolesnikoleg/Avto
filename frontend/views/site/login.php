<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ВХОД';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
    <section>
		
			<div class="container">
				
				<!--<form action="#" class="myform">-->
                                     <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'myform']]); ?>
                                
                                        <p class="head"><?= Html::encode($this->title) ?></p>
                                        
                                        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
                                        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                                        
                                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                
                                        <p class="reset_pass">
                                            Если Вы не помните пароль, Вы можете <?= Html::a('восстановить его', ['site/request-password-reset']) ?>!
                                        </p>
                                
                                        <?= Html::submitButton('ВОЙТИ', ['name' => 'login-button']) ?>
				<?php ActiveForm::end(); ?>
			</div>
		
	</section>

</div>
