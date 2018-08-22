<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use frontend\assets\MapContactsAsset;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;

MapContactsAsset::register($this);
?>
<section class="page contacts">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>КОНТАКТЫ</h2>
            </div>
        </div>
    </div>
    
    <div id="map_contacts"></div>
</section>

<script>
	function initMapContacts() {
		var uluru = {lat: 47.90275626, lng: 33.36108552};
		var map_contacts = new google.maps.Map(document.getElementById('map_contacts'), {
			zoom: 15,
			center: uluru
		});
		var marker = new google.maps.Marker({
			position: uluru,
			map: map_contacts
		});
	}
</script>

<section class="contacts">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="contacts_block">
                    <p><i class="fas fa-phone"></i>(097)123-45-67, (097)123-45-67, (097)123-45-67, (097)123-45-67</p>
                    <p><i class="fas fa-map-marker-alt"></i>Украина, г. Кривой Рог, ул. Кобылянского, 219 (офис 2)</p>
                    <p><i class="far fa-clock"></i>Пн-Пт: с 9:00 до 18:00, Сб: с 10:00 до 16:00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="page contacts">
    <div class="container">
        <div class="row">
            <h2>НАПИШИТЕ НАМ</h2>
            <div class="col-xs-12">
                
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
                    
                <?php
                if (Yii::$app->session->getFlash('error')):
                ?>
                    <p class="mes red" style="display:block">
                        <span class="text"><?php print_r (Yii::$app->session->getFlash('error')) ?></span>
                        <br />
                        <span class="cls">ЗАКРЫТЬ</span>
                    </p>
                <?php
                endif;
                ?>
                
                 
                        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'myform']]); ?>

                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Например, Иван']) ?>
                                </div>

                                <div class="col-sm-6">
                                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Например, 097-777-77-77']) ?>
                                </div>
                            </div>
                                
                            <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => 'Например, Удачного Вам дня!']) ?>

                            <div class="form-group">
                                <?= Html::submitButton('ОТПРАВИТЬ', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                
            </div>
        </div>
    </div>
</section>