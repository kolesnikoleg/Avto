<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = 'Изменение заказа ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Сохранить';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
$js = <<<JS
        
        
$('.delete').on("click", function(){
    var isDelete = confirm("Вы хотите удалить товар из заказа?");
    if (isDelete) {
        var id = $(this).attr('id');
        
        $.ajax({
		url: "/order/delete-product",
		type: 'post',
		data: {id: id},
		success: function(data){
			if (data == '1')
			{
				alert('Успех! Товар был удален. Перезагружаем страницу!');
                                $('button').trigger('click');
			}	
			if (data == '-1')
			{
				alert('Ошибка! Попробуйте позже.');
			}	
		},
		error: function(error){
			alert('Ошибка AJAX: ' + error);
		},
		// dataType: 'json'
	});
    }
});        

JS;

$this->registerJs($js);

?>







<?php

$js = <<<JS

$(document).ready(function() {
        $('.popup-with-zoom-anim.pay').on("click", function(){
            $('#small-dialog-pay .subm').attr('id', $(this).attr('id'));
        });
        
	$('.popup-with-zoom-anim.pay').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});
        
JS;

$this->registerJs($js);
?>

<!-- dialog itself, mfp-hide class is required to make dialog hidden -->
<div id="small-dialog-pay" class="zoom-anim-dialog mfp-hide">
	<h1>Провести оплату</h1>
        <p class="label">Введите новую сумму:</p>
        <input type="text" name="pay">
        <p class="error"></p>
        <a class="subm">Провести</a>
</div>

<?php
$js = <<<JS
$('#small-dialog-pay .subm').on("click", function(){
        var id = $(this).attr('id');
        var value = $('#small-dialog-pay input[name=pay]').val();
        
        if (value == '') {
            value = 0;
        }
        
	$.ajax({
		url: "/order/pay",
		type: 'post',
		data: {id: id, value: value},
		success: function(data){
			if (data == '1')
			{
                            alert('Успех! Оплата была проведена. Перезагружаем страницу!');
                            $('button').trigger('click');
			}	
			if (data == '-1')
			{
				alert('Ошибка! Попробуйте позже.');
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

?>







<?php

$js = <<<JS

$(document).ready(function() {
        $('.popup-with-zoom-anim.count').on("click", function(){
            $('#small-dialog-count .subm').attr('id', $(this).attr('id'));
        });
        
	$('.popup-with-zoom-anim.count').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});
        
JS;

$this->registerJs($js);
?>

<!-- dialog itself, mfp-hide class is required to make dialog hidden -->
<div id="small-dialog-count" class="zoom-anim-dialog mfp-hide">
	<h1>Изменить количество</h1>
        <p class="label">Введите новое количество:</p>
        <input type="text" name="count">
        <p class="error"></p>
        <a class="subm">Изменить</a>
</div>

<?php
$js = <<<JS
$('#small-dialog-count .subm').on("click", function(){
        var id = $(this).attr('id');
        var value = $('#small-dialog-count input[name=count]').val();
        
        if (value == '') {
            value = 0;
        }
        
	$.ajax({
		url: "/order/count",
		type: 'post',
		data: {id: id, value: value},
		success: function(data){
			if (data == '1')
			{
                            alert('Успех! Количество было изменено. Перезагружаем страницу!');
                            $('button').trigger('click');
			}	
			if (data == '-1')
			{
				alert('Ошибка! Попробуйте позже.');
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

?>







<?php

$js = <<<JS

$(document).ready(function() {
        $('.popup-with-zoom-anim.dost').on("click", function(){
            $('#small-dialog-dost .subm').attr('id', $(this).attr('id'));
        });
        
	$('.popup-with-zoom-anim.dost').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
});
        
JS;

$this->registerJs($js);
?>

<!-- dialog itself, mfp-hide class is required to make dialog hidden -->
<div id="small-dialog-dost" class="zoom-anim-dialog mfp-hide">
	<h1>Изменить доставку</h1>
        <p class="label">Введите новую стоимость доставки:</p>
        <input type="text" name="dost">
        <p class="error"></p>
        <a class="subm">Изменить</a>
</div>

<?php
$js = <<<JS
$('#small-dialog-dost .subm').on("click", function(){
        var id = $(this).attr('id');
        var value = $('#small-dialog-dost input[name=dost]').val();
        
        if (value == '') {
            value = 0;
        }
        
	$.ajax({
		url: "/order/dost",
		type: 'post',
		data: {id: id, value: value},
		success: function(data){
			if (data == '1')
			{
                            alert('Успех! Стоимость доставки была изменена. Перезагружаем страницу!');
                            $('button').trigger('click');
			}	
			if (data == '-1')
			{
                            alert('Ошибка! Попробуйте позже.');
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

?>