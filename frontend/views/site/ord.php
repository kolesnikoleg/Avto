<?php

use yii\helpers\Html;
use frontend\models\Carts;
use yii\widgets\ActiveForm;

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page ord">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>ОФОРМЛЕНИЕ ЗАКАЗА</h2>
                
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
                
                <?php if ( (Yii::$app->user->isGuest AND isset($_SESSION['cart'])) OR (!Yii::$app->user->isGuest AND (new Carts())->find()->where(['user_id' => Yii::$app->user->identity->id])->count() > 0)): ?> 
                    
                    <p class="ord_to">ВЫ ОФОРМЛЯЕТЕ ЗАКАЗ КАК <?php if (Yii::$app->user->isGuest): echo '<span class="red">ГОСТЬ</span>'; else: echo 'ПОЛЬЗОВАТЕЛЬ <span class="red">'.Yii::$app->user->identity->username.'</span>'; endif; ?></p>
                    <p class="ord_to">СУММА ЗАКАЗА: <span class="red"><?php $cart = new Carts(); echo $cart->getTotalProductsPricesCurrencyCart(); ?> ГРН</span></p>

                    <?php if (Yii::$app->user->isGuest): ?>
                        <p class="how_ord">КАК ВЫ ХОТИТЕ ОФОРМИТЬ ЗАКАЗ?</p>
                        <div class="ord_choice">
                            <div class="one">
                                <a class="head" href="/login">ВОЙТИ В АККАУНТ</a>
                            </div>
                            <div class="one">
                                <a class="head" href="/signup">СОЗДАТЬ АККАУНТ</a>
                            </div>
                            <div class="one">
                                <div class="head">
                                   БЕЗ РЕГИСТРАЦИИ
                                </div>
                                <div class="content">
                                    <?php $form = ActiveForm::begin(['id' => 'form-settings', 'options' => ['class' => 'myform'],]); ?>

                                    <div class="row">
                                        <div class="col-sm-12"><?= $form->field($model, 'phone')->input('text', ['placeholder' => 'Например: 097-123-45-67'])->label('Мобильный телефон <span class="red">*</span>') ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12"><?= $form->field($model, 'dostavka')->input('text', ['placeholder' => 'Например: Новая почта, Киев, отделение 100, 097-123-45-67, Иванов Иван Иванович']) ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12"><?= $form->field($model, 'client_comment')->textarea(['placeholder' => 'Например: Заказ нужен как можно быстрее!']) ?></div>
                                    </div>

                                    <?= Html::submitButton('ЗАКАЗАТЬ', ['class' => 'btn btn-primary', 'name' => 'settings-order']) ?>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

                        <?php $form = ActiveForm::begin(['id' => 'form-settings', 'options' => ['class' => 'myform']]); ?>

                        <div class="row">
                            <div class="col-sm-12"><?= $form->field($model, 'phone')->input('text', ['placeholder' => 'Например: 097-123-45-67'])->label('Мобильный телефон <span class="red">*</span>') ?></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12"><?= $form->field($model, 'dostavka')->input('text', ['placeholder' => 'Например: Новая почта, Киев, отделение 100, 097-123-45-67, Иванов Иван Иванович']) ?></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12"><?= $form->field($model, 'client_comment')->textarea(['placeholder' => 'Например: Заказ нужен как можно быстрее!']) ?></div>
                        </div>

                        <?= Html::submitButton('ЗАКАЗАТЬ', ['class' => 'btn btn-primary', 'name' => 'settings-order']) ?>

                        <?php ActiveForm::end(); ?>

                    <?php endif; ?>
                <?php else: ?>
                    <p class='ord_to'>ВАША КОРЗИНА ПОКУПОК ПУСТА!</p>
                    <p class='ord_to'>ЧТОБЫ ОФОРМИТЬ ЗАКАЗ, ДОБАВЬТЕ В КОРЗИНУ ХОТЯ БЫ ОДИН ТОВАР</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
if (Yii::$app->user->isGuest) $gues = 1; else $gues = 0;

$js = <<<JS
$(document).ready(function(){
    $('.ord_choice .one .head').on("click", function(){
        if ($(this).parents('.one').children('.content').css('display') == 'none')
        {
            $('.ord_choice .one .head').removeClass('active');
            $('.ord_choice .one .content').hide(400);
            $(this).parents('.one').children('.content').show(400);
            $(this).addClass('active');
        }
        else
        {
            $(this).parents('.one').children('.content').hide(400);
            $(this).removeClass('active');
        }
    });       
}); 

        
JS;

$this->registerJs($js);
?>