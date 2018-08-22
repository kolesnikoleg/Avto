<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\MapAsset;
use common\widgets\Alert;
use yii\web\JqueryAsset;
use frontend\models\Menu;
use frontend\models\Settings;
use yii\i18n\Formatter;
use frontend\models\Carts;
use frontend\models\PricesList;

$session = Yii::$app->session;

AppAsset::register($this);

if (Yii::$app->controller->action->id !== 'contacts') {
    MapAsset::register($this);
}



echo Yii::$app->controller->action->id;


$m_settings = new Settings();
$settings = [];
$settings['cur_USD'] = $m_settings->getCurrencyUSD();
$settings['cur_EURO'] = $m_settings->getCurrencyEURO();
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
        <html lang="<?= Yii::$app->language ?>">
	<meta charset="<?= Yii::$app->charset ?>">
	<title><?= Html::encode($this->title) ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?= Html::csrfMetaTags() ?>
	<link rel="shortcut icon" href="/favicon.png" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="top_menu">
            <p class="logo"><a href="/">AVTO<span class="red">MAGIC</span></a></p>
            <div class="btns">
                <div class="bars"><i class="fas fa-bars"></i></div>
                <div class="up_arr"><i class="fas fa-arrow-up"></i></div>
                <a class="cart" href="/cart">
                    <span class="val"><?php if (Yii::$app->user->isGuest) { if (isset($_SESSION['cart'])) echo (new Carts())->getTotalProducts(); else echo 0; } else { echo (new Carts())->getTotalProducts(); } ?></span>
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>

            <?= Html::beginForm(['/search'], 'post',  ['class' => 'search_up']) ?>

            <?= Html::input('text', 'search', '', ['placeholder' => 'ПОИСК ЗАПЧАСТЕЙ ПО КОДУ']) ?>

            <?= Html::submitButton('<i class="fas fa-search"></i>') ?>

            <?= Html::endForm(); ?>
	</div>

	<div class="over_menu">
		<div class="cl"><i class="fas fa-times"></i></div>
		<div class="container">
			<p class="logo"><img src="/img/main_logo.jpg" alt="Автомеджик"></p>
                        
                        <?= Html::beginForm(['/search'], 'post',  ['class' => 'search']) ?>
                                    
                        <?= Html::input('text', 'search', '', ['placeholder' => 'ПОИСК']) ?>

                        <div class="icon_search"><i class="fas fa-search"></i></div>

                        <?= Html::submitButton('ПОИСК') ?>

                        <div class="clear"></div>

                        <?= Html::endForm(); ?>
                        
			<div class="reg">
                                
                                <?php
                                if (Yii::$app->user->isGuest) {
                                    ?>
                                    <a href="/login">ВХОД</a>
                                    <a href="/signup">РЕГИСТРАЦИЯ</a>
                                    <?php
                                } else {
                                    ?>
                                
                                      <div class="name_hello">Приветствуем, <span class="login"><?= Yii::$app->user->identity->username; ?></span></div>
                                                                            
                                                                             <?php
                                                                        $exit_form = '';
                                                                        $exit_form 
                                                                           
                                                                        .= Html::beginForm(['/site/logout'], 'post',  ['class' => 'myform mnu', 'style' => "display:inline-block;"])
                                                                        . '<a href="/user/index" style="display:inline-block;">МОЙ АККАУНТ</a>'
                                                                                . Html::submitButton(
                                                                            'ВЫХОД',
                                                                            ['class' => 'btn btn-link logout', 'style' => 'display:inline-block;vertical-align: baseline;']
                                                                        )
                                                                                
                                                                        . Html::endForm();
                                                                        
                                                                        echo $exit_form ;
                                                                        ?>
                                                                    
                                                                    <?php
                                }
                                ?>
                                
			</div>
			<div class="cart">
				<i class="fas fa-shopping-cart"></i>
				<a href="/cart">
                                    <span id="cart_count">ТОВАРОВ: <?= (new Carts())->getTotalProductsCart() ?></span>
					<span class="red">(<span id="cart_amount"><?= Yii::$app->formatter->asDecimal( (new Carts())->getTotalProductsPricesCurrencyCart(), 2);?></span> ГРН)</span>
				</a>
			</div>
			<p class="main_menu_tog main"><span>ГЛАВНОЕ МЕНЮ</span></p>
			<div class="main_menu_main">
                            <?php
                            $model = new Menu();
                            $menu = $model->getAllMenu();
                            foreach ($menu as $key => $value):
                                if ($key != 'active'):
                                ?>
                                    <p><a href="<?= $value ?>"<?php if (isset($menu['active']) AND $menu['active'] == $value): echo ' class="active"'; endif; ?>><?= $key ?></a></p>
                                <?php
                                endif;
                            endforeach;
                            ?>
			</div>
                        
                        <?php
                        if (!Yii::$app->user->isGuest)
                        {
                        ?><p class="main_menu_tog my"><span>МОЕ МЕНЮ</span></p>
                            <div class="main_menu_my">
                                <?php
                                $model = new Menu();
                                $menu = $model->getAllMyMenu();
                                foreach ($menu as $key => $value):
                                    if ($key != 'active'):
                                    ?>
                                        <p><a href="<?= $value ?>"<?php if ('/'.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == $value): echo ' class="active"'; endif; ?>><?= $key ?></a></p>
                                    <?php
                                    endif;
                                endforeach;

                                $exit_form = '';
                                $exit_form 

                                .= Html::beginForm(['/site/logout'], 'post',  ['class' => 'myform mnu', 'style' => "display:inline-block;"])
                                . Html::submitButton(
                                    'ВЫХОД',
                                    ['class' => 'btn btn-link logout']
                                )
                                . Html::endForm();

                                echo $exit_form ;

                                ?>
                            </div>
                        
                        <?php
                        }
                        ?>
                        
			<div class="vin">
				<i class="fas fa-barcode"></i>
				<a href="<?= $arr = Yii::$app->params['dop_menu']['vin'] ?>">
					<span><span class="red">VIN</span>-ЗАПРОС</span>
				</a>
			</div>
			<div class="boxes">
				<p class="stock"><i class="fas fa-box-open"></i><span class="dash"><a href="<?= $arr = Yii::$app->params['dop_menu']['stock'] ?>">СКЛАДСКИЕ ОСТАТКИ</a></span></p>
				<p class="stock"><i class="fas fa-box-open"></i><span class="dash"><a href="<?= $arr = Yii::$app->params['dop_menu']['price'] ?>">Б/У ПРАЙС</a></span></p>
			</div>
			<div class="contacts">
				<p><i class="fas fa-phone"></i>(097)123-45-67, (097)123-45-67, (097)123-45-67, (097)123-45-67</p>
				<p><i class="fas fa-map-marker-alt"></i>Украина, г. Кривой Рог, ул. Кобылянского, 219 (офис 2)</p>
				<p><i class="far fa-clock"></i>Пн-Пт: с 9:00 до 18:00, Сб: с 10:00 до 16:00</p>
			</div>
		</div>
	</div>
	
	<header>
		<div class="container">
			<div class="row">
				<div class="up_line">
					<div class="main_logo"><img src="/img/main_logo.jpg" alt="Avtomagic"></div>
					<div class="main_menu">
						<div class="hid">
							<div class="sector">
								<img src="/img/round.jpg" alt="Окна">
							</div>
                                                    <?php
                                                    $model = new Menu();
                                                    $menu = $model->getMenuMore();
                                                    foreach ($menu as $key => $value):
                                                        if (!is_array($value)):
                                                            if ($key != 'active'):
                                                            ?>
                                                                <a href="<?= $value ?>"<?php if (isset($menu['active']) AND $menu['active'] == $value): echo 'class="active"'; endif; ?>"><?= $key ?></a>&nbsp;&nbsp;<span class="red">|</span>&nbsp;&nbsp;
                                                            <?php
                                                            endif;
                                                        else:
                                                            ?>
                                                                <a href="#" class="more_mnu">Еще</a>
                                                                <div class="popup_menu">
                                                                    <?php
                                                                    foreach ($value as $key_1 => $value_1):
                                                                    ?>
                                                                        <div><a href="<?= $value_1 ?>"><?= $key_1 ?></a></div>
                                                                    <?php
                                                                    endforeach;
                                                                    ?>
                                                                </div>
                                                            <?php
                                                        endif;
                                                        
                                                    endforeach;
                                                    ?>
						</div>
						<div class="mob">
							<div class="sector">
								<img src="/img/round.jpg" alt="Окна">
							</div>
							<i class="fas fa-bars"></i>
						</div>
					</div>
					<div class="grey_line"></div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="contacts">
						<p><i class="fas fa-phone"></i>(097)123-45-67, (097)123-45-67, (097)123-45-67, (097)123-45-67</p>
						<p><i class="fas fa-map-marker-alt"></i>Украина, г. Кривой Рог, ул. Кобылянского, 219 (офис 2)</p>
						<p><i class="far fa-clock"></i>Пн-Пт: с 9:00 до 18:00, Сб: с 10:00 до 16:00</p>
                                                <p class="recall_me"><i class="fas fa-share"></i><span class="dash"><a class="call_me" href="#recall_me">ПЕРЕЗВОНИТЕ МНЕ</a></span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-md-6 col-lg-7"></div>
				<div class="col-sm-8 col-md-6 col-lg-5">
					<div class="row">
						<div class="col-sm-5">
							<div class="boxes">
								<p class="stock"><i class="fas fa-box-open"></i><span class="dash"><a href="<?= $arr = Yii::$app->params['dop_menu']['stock'] ?>">СКЛАДСКИЕ ОСТАТКИ</a></span></p>
								<p class="stock"><i class="fas fa-box-open"></i><span class="dash"><a href="<?= $arr = Yii::$app->params['dop_menu']['price'] ?>">Б/У ПРАЙС</a></span></p>
							</div>
							<div class="vin">
								<i class="fas fa-barcode"></i>
								<a href="<?= $arr = Yii::$app->params['dop_menu']['vin'] ?>">
									<span><span class="red">VIN</span>-ЗАПРОС</span>
								</a>
							</div>
							<div class="exchange">
								<p>USD: 1$ = <span class="red"><?= Yii::$app->formatter->asDecimal($settings['cur_USD'], 2); ?></span> UAH</p>
								<p>EUR: 1€ = <span class="red"><?= Yii::$app->formatter->asDecimal($settings['cur_EURO'], 2); ?></span> UAH</p>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="reg">
								
								<?php
                                                                if (Yii::$app->user->isGuest) {
                                                                ?>
                                                                <a href="/login">ВХОД</a>
                                                                <a href="/signup">РЕГИСТРАЦИЯ</a>
                                                                <?php
                                                                    } else {
                                                                         ?>
                                                                    <div class="name_hello">Приветствуем, <span class="login"><?= Yii::$app->user->identity->username; ?></span></div>
                                                                            
                                                                             <?php
                                                                        $exit_form = '';
                                                                        $exit_form 
                                                                           
                                                                        .= Html::beginForm(['/site/logout'], 'post',  ['class' => 'myform mnu', 'style' => "display:inline-block;"])
                                                                        . Html::submitButton(
                                                                            'ВЫХОД',
                                                                            ['class' => 'btn btn-link logout']
                                                                        )
                                                                        . Html::endForm();
                                                                        
                                                                        echo $exit_form ;
                                                                        ?>
                                                                    <a href="/user/index" style="display:inline-block;">МОЙ АККАУНТ</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                                
                                                                
							</div>
							<div class="cart">
								<i class="fas fa-shopping-cart"></i>
								<a href="/cart">
                                                                        <span id="cart_count">ТОВАРОВ: <?= (new Carts())->getTotalProductsCart();?></span>
									<span class="red">(<span id="cart_amount"><?= Yii::$app->formatter->asDecimal( (new Carts())->getTotalProductsPricesCurrencyCart(), 2); ?></span> ГРН)</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-xs-12">
                                    <?= Html::beginForm(['/search'], 'post',  ['class' => 'search']) ?>
                                    
                                    <?= Html::input('text', 'search', '', ['placeholder' => 'ПОИСК ЗАПЧАСТЕЙ ПО КОДУ']) ?>
                                    
                                    <div class="icon_search"><i class="fas fa-search"></i></div>
                                    
                                    <?= Html::submitButton('ПОИСК') ?>
                                    
                                    <div class="clear"></div>
                                    
                                    <?= Html::endForm(); ?>
				</div>
			</div>
		</div>
	</header>

	

    <?= $content ?>
    
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-3">
					<div class="wrapper contacts">
						<div class="head">
							<a href="">AVTO<span class="red">MAGIC</span></a>
						</div>
						<div class="one">
							<div class="icon">
								<i class="fas fa-phone"></i>
							</div>
							<div class="content">
								<p>(097)123-45-67</p>
								<p>(097)123-45-67</p>
								<p>(097)123-45-67</p>
								<p>(097)123-45-67</p>
							</div>
						</div>
						<div class="clear"></div>
						<div class="one">
							<div class="icon">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<div class="content">
								<p>Украина, г. Кривой Рог</p>
								<p>ул. Кобылянского, 219</p>
								<p>офис 2</p>
							</div>
						</div>
						<div class="clear"></div>
						<div class="one">
							<div class="icon">
								<i class="far fa-clock"></i>
							</div>
							<div class="content">
								<p>Пн-Пт: с 9:00 до 18:00</p>
								<p>Сб: с 10:00 до 16:00</p>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-3">
					<div class="wrapper message">
						<div class="head">
							<span class="red">СВЯЗЬ</span> С НАМИ
						</div>
						<form action="">
							<p class="label">ВАШЕ ИМЯ</p>
							<input type="text" name="name">
							<p class="label">ВАШЕ EMAIL ИЛИ ТЕЛЕФОН</p>
							<input type="text" name="contact">
							<p class="label">ВАШЕ СООБЩЕНИЕ</p>
							<textarea name="message"></textarea>
							<p class="error">Сообщение отправлено!</p>
							<button>ОТПРАВИТЬ</button>
						</form>
					</div>
				</div>
				<div class="clearfix visible-xs-block visible-sm-block visible-md-block"></div>
				<div class="col-xs-12 col-sm-6 col-lg-3">
					<div class="wrapper mnu">
						<div class="head">
							<span class="red">МЕНЮ</span>
						</div>
						<ul class="mnu">
                                                    <?php
                                                    $model = new Menu();
                                                    $menu = $model->getMenuWithoutMore();
                                                    foreach ($menu as $key => $value):
                                                        if ($key != 'active'):
                                                        ?>
                                                            <li><a href="<?= $value ?>"<?php if (isset($menu['active']) AND $menu['active'] == $value): echo 'class="active"'; endif; ?>><?= $key ?></a></li>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
							<li><a<?php if ('/'.Yii::$app->controller->action->id == Yii::$app->params['dop_menu']['vin']): echo ' class="active"'; endif; ?>  href="<?= $arr = Yii::$app->params['dop_menu']['vin'] ?>">VIN-запрос</a></li>
							<li><a<?php if ('/'.Yii::$app->controller->action->id == Yii::$app->params['dop_menu']['stock']): echo ' class="active"'; endif; ?> href="<?= $arr = Yii::$app->params['dop_menu']['stock'] ?>">Складские остатки</a></li>
							<li><a<?php if ('/'.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == '/user/index'): echo ' class="active"'; endif; ?> href="/user/index">Личный кабинет</a></li>
							<li><a<?php if ('/'.Yii::$app->controller->action->id == '/cart'): echo ' class="active"'; endif; ?> href="/cart">Корзина</a></li>
							<li><a<?php if ('/'.Yii::$app->controller->action->id == '/offerta'): echo ' class="active"'; endif; ?> href="/offerta">Публичная оферта</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-3">
					<div class="wrapper map">
                                            
						<div class="head">
							<span class="red">КАРТА</span>
						</div>
                                            <div id="map">
                                                <?php
                                                
                                                if (Yii::$app->controller->action->id == 'contacts') {
                                                    echo '<img src="/img/map_footer.jpg">';
                                                }
                                                ?>
                                            </div>
						<a href="/site/contacts">ПОДРОБНЕЕ</a>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</footer>

	<div class="copyr">
		<div class="container">
			<p><a href="/">AVTO<span class="red">MAGIC</span></a>. 2012 - 2018. ВСЕ ПРАВА <span class="red">ЗАЩИЩЕНЫ</span>.</p>
		</div>
	</div>
	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
<![endif]-->

        <div id="recall_me" class="zoom-anim-dialog mfp-hide">
            <h3>ПЕРЕЗВОНИТЕ МНЕ</h3>
            <form class="recall_form">
                <p class="label">ВАШ НОМЕР ТЕЛЕФОНА <span class="red">*</span> :</p>
                <input name="phone" placeholder="ВАШ НОМЕР ТЕЛЕФОНА">
                <p class="label">ВАШЕ ИМЯ:</p>
                <input name="name" placeholder="ВАШЕ ИМЯ">
                <p class="label">КОГДА ВАМ ПЕРЕЗВОНИТЬ:</p>
                <input class="lst" name="time" placeholder="КОГДА ВАМ ПЕРЕЗВОНИТЬ">
                <p class="err">ОШИБКА! ВВЕДИТЕ НОМЕР ТЕЛЕФОНА!</p>
                <div class="a_subm">
                    <a class="subm">ОТПРАВИТЬ</a>
                </div>
            </form>
        </div>

<script>
	function initMap() {
		var uluru = {lat: 47.90275626, lng: 33.36108552};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: uluru
		});
		var marker = new google.maps.Marker({
			position: uluru,
			map: map
		});
	}
        
        

</script>

<?php $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', ['depends' => [
JqueryAsset::className()
]]); ?>
<?php $this->registerJsFile('js/owl-carousel/init.js', ['depends' => [
AppAsset::className()
]]); ?>
<?php $this->registerJsFile('libs/magnific-popup/jquery.magnific-popup.min.js', ['depends' => [
AppAsset::className()
]]); ?>
<?php $this->registerJsFile('js/common.js', ['depends' => [
AppAsset::className()
]]); ?>
<?php $this->endBody() ?>


<?php
if (Yii::$app->user->isGuest) $gues = 1; else $gues = 0;

$js = <<<JS
$(document).on("click", 'span#wl', function(){
    var guest = $gues;
        
    if (guest == 0)
    {
        var id = $(this).attr('class');
        var count = $(this).parent('td').children('input').val();
        $.ajax({
            url: "/wish-add",
            type: 'post',
            data: {action: 'wish-add', id: id, count: count},
            success: function(data){
                data = data.slice(5);
                data = JSON.parse(data);
                if (data[0] == true)
                {
                    $('.mes .text').text('Успех! Товар был добавлен в Список желаний!');
                    $('.mes').removeClass('red');
                    $('.mes').addClass('green');
                    $('.mes').show(350);
                }
                else
                {
                    if (data[1] != 'undefined' && data[1] == 'isset')
                    {
                        $('.mes .text').text('Ошибка! Этот товар уже есть в Вашем Списке желаний!');
                    }
                    else
                    {
                        $('.mes .text').text('Ошибка! Добавить товар в Список желаний не удалось!');
                    }
                    $('.mes').removeClass('green');
                    $('.mes').addClass('red');
                    $('.mes').show(350);
                }
            },
            error: function(error){
                alert('Ошибка Ajax: ' + error);
            },
            dataType: 'text'
        });
    }
    else
    {
        $('.mes .text').html('Ошибка! Чтобы добавить товар в Список желаний, Вам нужно <a href="/login">Войти</a> или <a href="/login">Зарегистрироваться</a>!');
        $('.mes').removeClass('green');
        $('.mes').addClass('red');
        $('.mes').show(350);
    }    
});    
$('.mes').on("click", function(){
    $(this).hide(350);
});

        
JS;

$this->registerJs($js);
?>


<?php
if (Yii::$app->user->isGuest) $gues = 1; else $gues = 0;

$js = <<<JS
$(document).on("click", 'span#add', function(){
    var guest = $gues;
        
    
        var id = $(this).attr('class');
        var count = $(this).parent('td').children('input').val();
        var min_order = $(this).parents('tr').find('.for_checked').text();
        
        var errors_add = new Array();
        if (Number.isInteger(parseInt(count)) && count > 0)
        {
            if (parseInt(min_order) > parseInt(count))
            {
                errors_add.push('Ошибка! Минимальное количество заказанного товара: ' + min_order + 'шт!');
            }
        }
        else
        {
            errors_add.push('Ошибка! Неправильное количество товара для добавления!');
        }
        
        
        
        if (errors_add.length == 0)
        {
            $.ajax({
                url: "/cart-add",
                type: 'post',
                data: {action: 'cart-add', id: id, count: parseInt(count, 10)},
                success: function(data){
                    data = data.slice(5);
                    data = JSON.parse(data);
                    if (data[0] == true)
                    {
                        $('.mes .text').text('Успех! Товар был добавлен в Корзину!');
                        $('.mes').removeClass('red');
                        $('.mes').addClass('green');
                        $('.mes').show(350);
                        $('header .cart #cart_count').text('ТОВАРОВ: ' + data[1]);
                        $('header .cart #cart_amount').text(data[2].toFixed(2));
                        $('.top_menu .btns .val').text(data[1]);
                        $('.over_menu .cart #cart_count').text('ТОВАРОВ: ' + data[1]);
                        $('.over_menu .cart #cart_amount').text(data[2].toFixed(2));
                    }
                    else
                    {
                        if (data[1] != 'undefined' && data[1] == 'isset')
                        {
                            $('.mes .text').text('Ошибка! Этот товар уже есть в Вашей Корзине!');
                        }
                        if (data[1] != 'undefined' && data[1] == 'min_order')
                        {
                            $('.mes .text').text('Ошибка! Минимальное количество товара для заказа: ' + data[2] + 'шт!');
                        }
                        if (data[1] == 'undefined')
                        {
                            $('.mes .text').text('Ошибка! Добавить товар в Корзину не удалось!');
                        }
        
                        $('.mes').removeClass('green');
                        $('.mes').addClass('red');
                        $('.mes').show(350);
                    }
                },
                error: function(error){
                    alert('Ошибка Ajax: ' + error);
                },
                dataType: 'text'
            });
        }
        else
        {
            $('.mes .text').text(errors_add[errors_add.length - 1]);
            $('.mes').removeClass('green');
            $('.mes').addClass('red');
            $('.mes').show(350);
        }
       
}); 

        
JS;

$this->registerJs($js);
?>


<?php

$js = <<<JS
$(document).on("click", '#recall_me a.subm', function(){
        
    var name = $('#recall_me input[name=name]').val();
    var phone = $('#recall_me input[name=phone]').val();
    var time = $('#recall_me input[name=time]').val();
        
    var err_recall = new Array();
        
    if (phone == '') {
        err_recall.push('Ошибка! Введите Ваш номер телефона!');
    }
        
    if (err_recall.length < 1) {
        $.ajax({
            url: "/recall",
            type: 'post',
            data: {action: 'recall', name: name, phone: phone, time: time},
            success: function(data){
                data = data.slice(5);
                data = JSON.parse(data);
                if (data[0] == true) {
                    $('#recall_me .err').text('Успех! Запрос был успешно отправлен!');
                    $('#recall_me a.subm').css('display', 'none');
                    $('#recall_me .err').fadeIn(350);
                    $('#recall_me .err').css('margin-bottom', '20px');
                    
                } else {
                    $('#recall_me .err').text(data[1]);
                    $('#recall_me .err').fadeIn(350);
                }
            },
            error: function(error){
                alert('Ошибка Ajax: ' + error);
            },
            dataType: 'text'
        });  
    } else {
        $('#recall_me .err').text(err_recall[err_recall.length - 1]);
        $('#recall_me .err').fadeIn(350);
    }
        
});    
$('#recall_me input').on("click", function(){
    $('#recall_me .err').hide(350);
});

        
JS;

$this->registerJs($js);
?>




<?php

$js = <<<JS
$(document).on("click", '.wrapper.message button', function(e){
        
    e.preventDefault();
        
    var name = $('.wrapper.message input[name=name]').val();
    var contact = $('.wrapper.message input[name=contact]').val();
    var message = $('.wrapper.message textarea[name=message]').val();
        
    var err_mess = new Array();
        
    if (contact == '') {
        err_mess.push('Введите телефон или Email!');
    }
        
    if (message == '') {
        err_mess.push('Введите сообщение!');
    }
        
    if (err_mess.length < 1) {
        $.ajax({
            url: "/recall",
            type: 'post',
            data: {action: 'mess', name: name, phone: contact, time: message},
            success: function(data){
                data = data.slice(5);
                data = JSON.parse(data);
                if (data[0] == true) {
                    $('.wrapper.message .error').text('Сообщение отправлено!');
                    $('.wrapper.message button').css('display', 'none');
                    $('.wrapper.message .error').fadeIn(350);
                    
                } else {
                    $('.wrapper.message .error').text(data[1]);
                    $('.wrapper.message .error').fadeIn(350);
                }
            },
            error: function(error){
                alert('Ошибка Ajax: ' + error);
            },
            dataType: 'text'
        });  
    } else {
        $('.wrapper.message .error').text(err_mess[err_mess.length - 1]);
        $('.wrapper.message .error').fadeIn(350);
    }
        
});    
$('.wrapper.message input, .wrapper.message textarea').on("click", function(){
    $('.wrapper.message .error').hide(350);
});

        
JS;

$this->registerJs($js);
?>



<?php
$setting_jivosite = new Settings();
if ($setting_jivosite->getStatusJivosite()):
    ?>
       <!-- КОД ЖИВОСАЙТА -->
    <?php
endif;
?>

</body>
</html>
<?php $this->endPage() ?>
