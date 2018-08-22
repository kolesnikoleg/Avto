<?php


use yii\db\Query;

/* @var $this yii\web\View */

$this->title = 'Avtomagic';
//use yii\web\UrlManager;
?>
<section>
		<article id="how_order">
			<div class="container">
				<p class="head">КАК ЗАКАЗАТЬ ДЕТАЛЬ?</p>
				<p class="under_head">САМОСТОЯТЕЛЬНО</p>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<div class="icon">1</div>
						<div class="text">Найти в любом автокаталоге (в Интернете) номер нужно Вам детали</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">2</div>
						<div class="text">Вставьте код детали в строку поиска и нажмите кнопку "Найти"</div>
					</div>
					<div class="clearfix visible-xs-block visible-sm-block"></div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">3</div>
						<div class="text">Добавьте в Корзину подходящий Вам вариант из результатов Поиска</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">4</div>
						<div class="text">Подтвердите заказ и ожидайте звонок от наших менеджеров</div>
					</div>
				</div>
				<p class="under_head">С ПОМОЩЬЮ НАШИХ МЕНЕДЖЕРОВ</p>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<div class="icon">1</div>
						<div class="text">Нажмите кнопку "VIN-ЗАПРОС" в верхней части сайта</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">2</div>
						<div class="text">Заполните форму, включая VIN-НОМЕР Вашего автомобиля (есть в техпаспорте)</div>
					</div>
					<div class="clearfix visible-xs-block visible-sm-block"></div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">3</div>
						<div class="text">Дождитесь звонка от наших менеджеров и сообщите нужную Вам деталь</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="icon">4</div>
						<div class="text">Выберите из предложенных Вам вариантов и далее следуйте инструкциям менеджера</div>
					</div>
				</div>
				<p class="under_head">НОВОСТИ</p>
                                <?php
                                $news = (new Query())->select(['*'])->from('news')->where(['status' => '1'])->orderBy('id DESC')->limit(2)->all();
                                ?>
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<p class="header"><?= $news[0]['title'] ?></p>
						<p class="date">ДОБАВЛЕНО: <?= $news[0]['date'] ?></p>
						<p class="content"><?= $news[0]['content'] ?></p>
						<a class="all_news" href="/news">ВСЕ НОВОСТИ</a>
					</div>
					<div class="col-xs-12 col-md-6">
						<p class="header"><?= $news[1]['title'] ?></p>
						<p class="date">ДОБАВЛЕНО: <?= $news[1]['date'] ?></p>
						<p class="content"><?= $news[1]['content'] ?></p>
						<a class="all_news" href="/news">ВСЕ НОВОСТИ</a>
					</div>
				</div>
				<p class="under_head">НАШИ ПАРТНЕРЫ</p>
				<p class="switchers">
					<span class="all">ВЕСЬ СПИСОК</span>&nbsp;&nbsp;/&nbsp;&nbsp; 
					<span class="gallery">В ВИДЕ ГАЛЕРЕИ</span>
				</p>
				<div class="partners">
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_audi.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_bmw.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_mercedes.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_mercedes.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_mercedes.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_audi.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_bmw.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_audi.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_audi.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_bmw.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_mercedes.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_mercedes.png" alt=""></div>
						<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img src="img/partners/logo_toyota.png" alt=""></div>
					</div>
				</div>
				<div class="partners_gallery">
					<div class="row">
						<div class="col-xs-2 col-sm-1">
							<div class="arr_left">
								<i class="fas fa-angle-left"></i>
							</div>
						</div>
						<div class="col-xs-8 col-sm-10">
							<div class="owl-carousel">
								<div><img src="img/partners/logo_audi.png" alt=""></div>
								<div><img src="img/partners/logo_bmw.png" alt=""></div>
								<div><img src="img/partners/logo_toyota.png" alt=""></div>
								<div><img src="img/partners/logo_mercedes.png" alt=""></div>
								<div><img src="img/partners/logo_bmw.png" alt=""></div>
								<div><img src="img/partners/logo_toyota.png" alt=""></div>
								<div><img src="img/partners/logo_audi.png" alt=""></div>
								<div><img src="img/partners/logo_mercedes.png" alt=""></div>
								<div><img src="img/partners/logo_bmw.png" alt=""></div>
							</div>
						</div>
						<div class="col-xs-2 col-sm-1">
							<div class="arr_right">
								<i class="fas fa-angle-right"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
	</section>