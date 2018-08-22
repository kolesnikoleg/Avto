<?php

/* @var $this yii\web\View */

$this->title = 'Avtomagic';
//use yii\web\UrlManager;

use frontend\models\Menu;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\user\Settings;
use yii\widgets\ActiveForm;
use frontend\models\user\Messages;
?>
<section class="page">
	<div class="container">
		<div class="row">
			<h2>НАСТРОЙКИ</h2>
			<div class="col-xs-12">
				<div class="my_menu">
					<?php
					$my_model = new Menu();
					$menu = $my_model->getAllMyMenu();
					foreach ($menu as $key => $value):
						if ($key != 'active'):
							?>
							<?php $nazv = str_replace(' ', '&nbsp;', $key); ?>
							<a href="<?= $value ?>"><?= $nazv ?><?php if ($value == '/user/messages') if ((new Messages())->getCountNotReadMyMessages() > 0) echo '<span class="new_mess">'.(new Messages())->getCountNotReadMyMessages().'</span>'; ?></a>
							<?php
						endif;
					endforeach;

					$exit_form = '';
					$exit_form 

					.= Html::beginForm(['/site/logout'], 'post',  ['class' => 'my_form my_mnu', 'style' => "display:inline-block;"])
					. Html::submitButton(
						'ВЫХОД',
						['class' => 'btn btn-link logout']
					)
					. Html::endForm();

					echo $exit_form ;
					?>
				</div>
                            
                            
                            
                                 <?php $form = ActiveForm::begin(['id' => 'form-settings', 'options' => ['class' => 'myform'],]); ?>
                                        
                                        <div class="row">
                                            <div class="col-sm-6"><?= $form->field($model, 'email')->input('text', ['placeholder' => 'Не указано!']) ?></div>
                                        
                                            <div class="col-sm-6"><?= $form->field($model, 'phone')->input('text', ['placeholder' => 'Не указано!']) ?></div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6"><?= $form->field($model, 'name')->input('text', ['placeholder' => 'Не указано!']) ?></div>
                                        
                                            <div class="col-sm-6"><?= $form->field($model, 'city')->input('text', ['placeholder' => 'Не указано!']) ?></div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12"><?= $form->field($model, 'address')->input('text', ['placeholder' => 'Не указано!']) ?></div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6"><?= $form->field($model, 'password_hash')->passwordInput()->input('text', ['placeholder' => 'Введите новый пароль']) ?></div>
                                        
                                            <div class="col-sm-6"><?= $form->field($model, 'password_confirm')->passwordInput()->label('ПОДТВЕРДИТЕ ПАРОЛЬ')->input('text', ['placeholder' => 'Подтвердите новый пароль']) ?></div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12"><?= $form->field($model, 'comment')->textarea(['placeholder' => 'Не указано!']) ?></div>
                                        </div>
                                            
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
                                    
                                        <?= Html::submitButton('СОХРАНИТЬ', ['class' => 'btn btn-primary', 'name' => 'settings-button']) ?>
                                        
				<?php ActiveForm::end(); ?>
                            
                            
                                
                            
                            
			</div>
			
			
		</div>
	</div>
</section>