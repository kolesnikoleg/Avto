<?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
/* @var $this yii\web\View */

$this->title = 'Мои заказы';
//use yii\web\UrlManager;
use frontend\models\Menu;
use yii\helpers\Html;
use frontend\models\user\Messages;
use yii\widgets\LinkPager;
use frontend\models\Status;

?>
<section class="page orders">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>МОИ ЗАКАЗЫ</h2>
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
                        
                    <?php if (empty($models)) echo '<p class="cart_empty" style="display:block">У ВАС НЕТ ЗАКАЗОВ В ЭТОМ РАЗДЕЛЕ</p>'; ?>
                        
                    <?php if (!empty($models)): ?>
                    <div class="all_btns">
                        <span class="all_open">РАЗВЕРНУТЬ&nbsp;ВСЕ</span> <span class="all_close">СВЕРНУТЬ&nbsp;ВСЕ</span>
                    </div>
                    <?php endif ?>
                    <div class="content_page">
                        <?php 
                        
                        foreach ($models as $model):
                               
                        ?>
                        <div class="block">
                            <div class="head">
                                <p class="h">ЗАКАЗ <?= $model->id ?></p>
                                <p class="text">ДАТА: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?>, <?= Yii::$app->formatter->asDate($model->date, 'php:H:i:s') ?></p>
                                <p class="text">СУММА: <?= Yii::$app->formatter->asDecimal($model->getOrderTotalPrice($model->id), 2) ?> ГРН</p>
                                <p class="text">СТАТУС: <?= (new Status())->getStatusById($model->status)['text'] ?></p>
                                <p class="more">ПОДРОБНЕЕ</p>
                            </div>
                            <div class="body">
                                <p class="str"><span class="red">АДРЕС:</span> <?= $model->dostavka ?></p>
                                <p class="str"><span class="red">КОНТАКТНЫЙ ТЕЛЕФОН:</span> <?= $model->phone ?></p>
                                <p class="str"><span class="red">КОММЕНТАРИЙ:</span> <?= $model->client_comment ?></p>
                                <p class="link archive"><span class="arc">ОТПРАВИТЬ В АРХИВ</span><span id="<?php echo $model->id ?>" class="archive_confirm">ТОЧНО ОТПРАВИТЬ</span></p>
                                <p class="link del"><span class="dl">УДАЛИТЬ ЗАКАЗ</span><span id="<?php echo $model->id ?>" class="del_confirm">ТОЧНО УДАЛИТЬ</span></p>
                                <div class="table table-order">
                                    <div class="table">
                                        <table>
                                            <tr>
                                                <td class="sm_hid">ПРОИЗВОДИТЕЛЬ</td>
                                                <td>НАИМЕНОВАНИЕ</td>
                                                <td>АРТИКУЛ</td>
                                                <td class="sm_hid">НАПРАВЛЕНИЕ</td>
                                                <td>ЦЕНА</td>
                                                <td>КОЛИЧЕСТВО</td>
                                                <td>СУММА</td>
                                                <td>ОПЛАТА</td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $products = json_decode($model->products, true);
                                            foreach ($products as $key => $product):
                                               
                                            
                                                if ($key !== 'total_payed' AND $key !== 'total_price' AND $key !== 'dostavka_val'):
                                                ?>
                                                <tr>
                                                    <td class="sm_hid"><?= $product['manufacturer'] ?></td>
                                                    <td><?= $product['name'] ?></td>
                                                    <td><?= $product['article'] ?></td>
                                                    <td class="sm_hid"><?= $product['price_list'] ?></td>
                                                    <td><?= Yii::$app->formatter->asDecimal($product['price'], 2) ?> ГРН</td>
                                                    <td><?= $product['count'] ?> ШТ</td>
                                                    <td><?= Yii::$app->formatter->asDecimal($product['count'] * $product['price'], 2) ?> ГРН</td>
                                                    <td><?= $product['payed'] ?> ГРН</td>
                                                    <td class="form">
                                                        <?= Html::beginForm(['/search'], 'post', ['target' => '_blank']) ?>
                                    
                                                            <p><?= Html::submitButton('Поиск по коду').'<br />'.$product['article'] ?></p>

                                                            <?= Html::input('hidden', 'search', $product['article'], ['placeholder' => 'ПОИСК']) ?>

                                                            <div class="clear"></div>

                                                        <?= Html::endForm(); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                endif;
                                            endforeach;
                                            
                                            if ($products['dostavka_val'] > 0) {
                                            ?>
                                            <tr class="empty"></tr>
                                            <tr class="dost">
                                                <td colspan="9">ДОСТАВКА: <?= $products['dostavka_val'] ?> ГРН</td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  
    //                       echo $model->date.'<br />';
                        endforeach;
                        ?>
                    </div>
                    
                    
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
if (Yii::$app->user->isGuest) $gues = 1; else $gues = 0;

$js = <<<JS
$(document).on("click", '.content_page .block .head', function(){
    if ($(this).parents('.block').children('.body').css('display') == 'none')
    {
        $(this).parents('.block').children('.body').show(400);
        $(this).addClass('active');
    }
    else
    {
        $(this).parents('.block').children('.body').hide(400);
        $(this).removeClass('active');
    }
}); 
        
$(document).on("click", '.all_btns .all_open', function(){
        $('.content_page .block .body').show(400);
        $('.content_page .block .head').addClass('active');
}); 
        
$(document).on("click", '.all_btns .all_close', function(){
        $('.content_page .block .body').hide(400);
        $('.content_page .block .head').removeClass('active');
}); 

$('.link.archive .arc').click(function(){
    if ($(this).parents('.link.archive').children('.archive_confirm').css('display') == 'none')
    {
        $(this).parents('.link.archive').children('.archive_confirm').fadeIn(400);
    }
    else
    {
        $(this).parents('.link.archive').children('.archive_confirm').fadeOut(400);
    }
});       

$('.link.del .dl').click(function(){
    if ($(this).parents('.link.del').children('.del_confirm').css('display') == 'none')
    {
        $(this).parents('.link.del').children('.del_confirm').fadeIn(400);
    }
    else
    {
        $(this).parents('.link.del').children('.del_confirm').fadeOut(400);
    }
});    
     
$('.link.archive .archive_confirm').on('click', function(){
    var id = $(this).attr('id');
        
    $.ajax({
        url: "ord-arc",
        type: 'post',
        data: {action: 'ord-arc', id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
            }
            else
            {
                $('.mes .text').text('Ошибка! Заказ НЕ был отправлен в Архив!');
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

});    
     
$('.link.del .del_confirm').on('click', function(){
    var id = $(this).attr('id');
        
    $.ajax({
        url: "ord-del",
        type: 'post',
        data: {action: 'ord-del', id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
            }
            else
            {
                $('.mes .text').text('Ошибка! Заказ НЕ был удален!');
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

});
        
JS;

$this->registerJs($js);
?>