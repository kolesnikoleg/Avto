<?php

/* @var $this yii\web\View */

$this->title = 'Avtomagic';
//use yii\web\UrlManager;

use frontend\models\Menu;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\user\Messages;
?>
<section class="page">
	<div class="container">
		
			<h2>ЛИЧНЫЙ КАБИНЕТ</h2>
                        <div class="row">
                            <div class="col-xs-12">
                                    <div class="my_menu">
                                            <?php
                                            $model = new Menu();
                                            $menu = $model->getAllMyMenu();
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
                            </div>
                        </div>
			<?php
			if ($email_warn == -1)
			{
				?>
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="email_warn">
								<div class="head">УВАЖАЕМЫЙ ПОСЕТИТЕЛЬ!</div>
								<div class="text">МЫ РЕКОМЕНДУЕМ ВАМ ВВЕСТИ ВАШ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ В РАЗДЕЛЕ <a href="/user/settings" target="_blank">НАСТРОЙКИ</a>. В ТАКОМ СЛУЧАЕ ВЫ СМОЖЕТЕ ПОЛУЧАТЬ УВЕДОМЛЕНИЯ О ИЗМЕНЕНИЯХ СТАТУСА ЗАКАЗОВ.</div>
								<a class="but_cl">ВСЕ ПОНЯТНО! <span class="red">ЗАКРЫТЬ</span> И НЕ ПОКАЗЫВАТЬ ЭТУ НАДПИСЬ!</a>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
                       
                            <div class="icons">
                                    <div class="row">
                                            <div class="col-sm-4">
                                                    <div class="icon"><i class="fas fa-user"></i></div>
                                                    <p class="head">ЛОГИН</p>
                                                    <p class="text"><?= Yii::$app->user->identity->username ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                    <div class="icon"><i class="far fa-calendar-alt"></i></div>
                                                    <p class="head">РЕГИСТРАЦИЯ</p>
                                                    <p class="text"><?= $date_reg ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                    <div class="icon"><i class="far fa-credit-card"></i></div>
                                                    <p class="head">БАЛАНС</p>
                                                    <p class="text"><?= $balance ?> ГРН</p>
                                            </div>
                                    </div>
                            </div>
                        

			<div class="info">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<div class="wrapper_left">
								<div class="one">ВСЕГО ЗАКАЗОВ: <span class="red"><?php echo $total_orders; ?></span></div>
								<div class="one">ЗАКАЗОВ НА СУММУ: <span class="red"><?php echo $total_parts_price; ?> ГРН</span></div>
								<div class="one">ЗАКАЗАНО ДЕТАЛЕЙ: <span class="red"><?= $total_parts ?> ШТ</span></div>
								<div class="one">ПОСЛЕДНИЙ ЗАКАЗ: <span class="red"><?php echo $date_last_order; ?></span></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="wrapper_right">
								<div class="one">ИМЯ: <span class="red"><?php if ($name !== null AND $name !== '' AND $name !== '-1'): echo $name; else: echo 'НЕ УКАЗАНО!'; endif; ?></span></div>
								<div class="one">ТЕЛЕФОН: <span class="red"><?php if ($phone !== null AND $phone !== '' AND $phone !== '-1'): echo $phone; else: echo 'НЕ УКАЗАНО!'; endif; ?></span></div>
								<div class="one addr">АДРЕС ДОСТАВКИ: <span class="red"><?php if ($address !== null AND $address !== '' AND $address !== '-1'): echo $address; else: echo 'НЕ УКАЗАНО!'; endif; ?></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
	</div>
</section>

<?php


$js = <<<JS
$('section.page .email_warn .but_cl').on("click", function(){
	$.ajax({
		url: "/user/email-warn",
		type: 'post',
		data: {action: 'email_warning'},
		success: function(data){
			if (data == '<?php1')
			{
				$('section.page .email_warn').hide(500);
			}	
			if (data == '<?php')
			{
				alert('Произошла ошибка! Попробуйте позже!');
			}	
		},
		error: function(error){
			alert('Ошибка AJAX: ' + error);
		},
		// dataType: 'json'
	});
});
JS;

$this->registerJs($js);