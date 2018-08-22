<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\i18n\Formatter;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            [
                'attribute' => 'email',
                'value' => function ($model) {
                    if ($model->email == '-1' OR $model->email == '') {
                        return '';
                    } else {
                        return $model->email;
                    }
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
                }
            ],
            'phone',
            [
                'attribute' => 'city',
                'value' => function ($model) {
                    if ($model->city == '-1' OR $model->city == '') {
                        return '-';
                    } else {
                        return $model->city;
                    }
                }
            ],
            'total_balance_plus',
            'balance',
            [
                'attribute' => 'name',
                'value' => function ($model) {
                    if ($model->name == '-1' OR $model->name == '') {
                        return '-';
                    } else {
                        return $model->name;
                    }
                }
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function($model) {
                    $str = '';
                    $str .= "
                        <p class='qck_btns'>
                            <a title='Добавить баланс' class='add_balance popup-with-zoom-anim' href='#small-dialog'><span class='".$model->id."'><i class='fas fa-plus-square'></i></span></a>
                            <a title='Уменьшить баланс' class='minus_balance popup-with-zoom-anim' href='#small-dialog-minus'><span class='".$model->id."'><i class='fas fa-minus-square'></i></span></a>
                            <a title='Вход под клиентом' class='enter' href='http://192.168.0.111:7777/admenter?id=".$model->id."' target='_blank'><i class='fas fa-user-circle'></i></span>
                        </p>
                            ";
                    return $str;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    ?>
    
    
</div>

<?php
$js = <<<JS
$(document).ready(function() {
        $('.popup-with-zoom-anim').on("click", function(){
            $('#small-dialog #client_id').text( $(this).children('span').attr('class') );
        });
        
	$('.popup-with-zoom-anim').magnificPopup({
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
<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
	<h1>Пополнить баланс</h1>
        <p>Вы пополняете баланс клиенту <span id="client_id"></span></p>
        <p class="label">Введите сумму пополнения:</p>
        <input type="text" name="add_balance">
        <p class="label">Введите комментарий для клиента:</p>
        <textarea name="comment" style="width:100%"></textarea>
        <p class="error"></p>
        <a class="subm">Пополнить</a>
</div>

<?php
$js = <<<JS
$('#small-dialog .subm').on("click", function(){
        var id = $('#small-dialog #client_id').text();
        var value = $('#small-dialog input[name=add_balance]').val();
        var comment = $('#small-dialog textarea[name=comment]').val();
        
        if (value == '' || value == 0 || value < 0) {
            $('#small-dialog .error').text('Ошибка в поле "Сумма"!');
            $('#small-dialog .error').css('display', 'block');
        } else {
            $.ajax({
                    url: "/user/add-balance",
                    type: 'post',
                    data: {action: 'add-balance', id: id, value: value, comment: comment},
                    success: function(data){
                            if (data == '1')
                            {
                                    alert('Успех! Баланс был пополнен. Перезагружаем страницу!');
                                    document.location.href = document.location.href;
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
        $('.popup-with-zoom-anim').on("click", function(){
            $('#small-dialog-minus #client_id').text( $(this).children('span').attr('class') );
        });
});     
JS;

$this->registerJs($js);
?>

<!-- dialog itself, mfp-hide class is required to make dialog hidden -->
<div id="small-dialog-minus" class="zoom-anim-dialog mfp-hide">
	<h1>Уменьшить баланс</h1>
        <p>Вы умеьшаете баланс клиента <span id="client_id"></span></p>
        <p class="label">Введите сумму снятия:</p>
        <input type="text" name="add_balance">
        <p class="label">Введите комментарий для клиента:</p>
        <textarea name="comment" style="width:100%"></textarea>
        <p class="error"></p>
        <a class="subm">Уменьшить</a>
</div>

<?php
$js = <<<JS
$('#small-dialog-minus .subm').on("click", function(){
        var id = $('#small-dialog-minus #client_id').text();
        var value = $('#small-dialog-minus input[name=add_balance]').val();
        var comment = $('#small-dialog-minus textarea[name=comment]').val();
        
        if (value == '' || value == 0 || value < 0) {
            $('#small-dialog-minus .error').text('Ошибка в поле "Сумма"!');
            $('#small-dialog-minus .error').css('display', 'block');
        } else {
            $.ajax({
                    url: "/user/minus-balance",
                    type: 'post',
                    data: {action: 'minus-balance', id: id, value: value, comment: comment},
                    success: function(data){
                            if (data == '1')
                            {
                                    alert('Успех! Баланс был уменьшен. Перезагружаем страницу!');
                                    document.location.href = document.location.href;
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