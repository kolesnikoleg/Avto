<?php



use yii\helpers\Html;
use frontend\models\Carts;
use frontend\models\PricesList;
use frontend\models\User;
use frontend\models\Markups;
use frontend\models\Product;

$this->title = 'Корзина товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page cart">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>КОРЗИНА</h2>
                
                <?php if (empty((new Carts())->getAllProductsFromCart()) AND !Yii::$app->user->isGuest AND isset($_SESSION['cart'])): ?>
                <p class="but emp" style="text-align:center"><span class="cart_import">ИМПОРТ ИЗ ВРЕМЕННОЙ КОРЗИНЫ</span></p>
                <?php endif; ?>
                
                <p class="mes green">
                    <span class="text">Успех! Корзина была обновлена!</span>
                    <br />
                    <span class="cls">ЗАКРЫТЬ</span>
                </p>
                
                <?php
                if (isset($_SESSION['help_flash'])) 
                {
                    if ($_SESSION['help_flash'][0] == 'min_order_false')
                    {
                    $min_ord = $_SESSION['help_flash'][1];

$js = <<<JS
    $('.mes .text').text("Ошибка! Минимальное количество для заказа: $min_ord!");
    $('.mes').removeClass('green');
    $('.mes').addClass('red');
    $('.mes').show(350);            
JS;
$this->registerJs($js);

                    unset($_SESSION['help_flash']);
                    }
                }
                ?>
                
                <?php
                if (isset($_SESSION['help_flash'])) 
                {
                    if ($_SESSION['help_flash'][0] == 'cart_rel_true')
                    {

$js = <<<JS
    $('.mes .text').text("Успех! Количество товара было изменено!");
    $('.mes').removeClass('red');
    $('.mes').addClass('green');
    $('.mes').show(350);            
JS;
$this->registerJs($js);

                    unset($_SESSION['help_flash']);
                    }
                }
                ?>
                
                
                <?php
                if (isset($_SESSION['help_flash'])) 
                {
                    if ($_SESSION['help_flash'][0] == 'cart_act_true')
                    {

$js = <<<JS
    $('.mes .text').text("Успех! Корзина была успешно актуализирована!");
    $('.mes').removeClass('red');
    $('.mes').addClass('green');
    $('.mes').show(350);            
JS;
$this->registerJs($js);

                    unset($_SESSION['help_flash']);
                    }
                }
                ?>
                
                <?php
                if (isset($_SESSION['help_flash'])) 
                {
                    if ($_SESSION['help_flash'][0] == 'cart_del_true')
                    {

$js = <<<JS
    $('.mes .text').text("Успех! Товар был удален!");
    $('.mes').removeClass('red');
    $('.mes').addClass('green');
    $('.mes').show(350);            
JS;
$this->registerJs($js);

                    unset($_SESSION['help_flash']);
                    }
                }
                ?>
                
                
                
                
                
                
                <?php
                if (isset($_SESSION['imp_added'])) 
                {
                    $added = $_SESSION['imp_added'];
                    $missed = $_SESSION['imp_missed'];

$js = <<<JS
    $('.mes .text').text("Успех! Корзина была успешно импортирована! Новых позиций: $added, пропущено (существующих): $missed");
    $('.mes').removeClass('red');
    $('.mes').addClass('green');
    $('.mes').show(350);            
JS;
$this->registerJs($js);

                    unset($_SESSION['imp_added']);
                    unset($_SESSION['imp_missed']);
                }
//                print_r($_SESSION['cart']); exit;
                ?>
                
                <p class="cart_empty"<?php if ( (new Carts())->isNotEmptyCart() === false ) { echo ' style="display:block;"'; } ?>>У Вас нет товаров в Корзине</p>
                    
                
                <p class="preloader">
                    <img src="img/pre.gif">
                </p>

                <div class="cart">
                    <div class="table">
                            <table>
                                <?php if (!empty((new Carts())->getAllProductsFromCart()))
                                {
                                    ?>
                                    <tr>
                                            <td class="sm_hid">ПРОИЗВОДИТЕЛЬ</td>
                                            <td>НАИМЕНОВАНИЕ</td>
                                            <td>АРТИКУЛ</td>
                                            <td class="sm_hid">НАПРАВЛЕНИЕ</td>
                                            <td>СР. СРОК</td>
                                            <td>ВЕС</td>
                                            <td>ЦЕНА</td>
                                            <td>СУММА</td>
                                            <td></td>
                                    </tr>
                                    <?php
                                }
                                    if (!empty($all_carts_products))
                                    {
                                        foreach ($all_carts_products as $key => $value)
                                        {
                                            ?>
                                                <tr class="<?= $key ?>">
                                                    <td class="sm_hid"><?= $value['product_info']['manufacturer']; ?></td>
                                                    <td><?= $value['product_info']['name']; ?></td>
                                                    <td><?= $value['product_info']['article']; ?></td>
                                                    <td class="sm_hid"><?= $value['product_info']['this_price_name']; ?></td>
                                                    <td><?= $value['product_info']['term']; ?></td>
                                                    <td><?= $value['product_info']['weight'] / 1000; ?> КГ</td>
                                                    <td><?php
                                                    
                                                    $product_for_price = new Product();
                                                    $product_for_price->getFromArrayProduct($value['product_info']);
                                                    
                                                    if ($product_for_price->getPriceCurrencyProduct() != $product_for_price->getPriceProduct())
                                                    {
                                                        echo $product_for_price->getPriceProduct() . ' ' . $product_for_price->currency . '<br>';
                                                        echo $product_for_price->getPriceCurrencyProduct() . ' ГРН';
                                                    }
                                                    else
                                                    {
                                                        echo $product_for_price->getPriceCurrencyProduct() . ' ГРН';
                                                    }
                                                    
                                                    ?></td>
                                                    <td><?php
                                                    if ($product_for_price->getPriceCurrencyProduct() != $product_for_price->getPriceProduct())
                                                    {
                                                        echo $product_for_price->getPriceProduct() * $value['product_count'] . ' ' . $product_for_price->currency . '<br>';
                                                        echo $product_for_price->getPriceCurrencyProduct() * $value['product_count'] . ' ГРН';
                                                    }
                                                    else
                                                    {
                                                        echo $product_for_price->getPriceCurrencyProduct() * $value['product_count'] . ' ГРН';
                                                    }
                                                    ?></td>
                                                    
                                                    <td>
                                                        <input type="text" style="width:29px;text-align:center" value="<?= $value['product_count'] ?>">
                                                        <span title="Изменить количество" id="rel" class="<?= 'prc_' . $value['product_info']['ident'] ?>"><i class="fas fa-sync-alt"></i></span>
                                                        <span title="Удалить из Корзины" id="del" class="<?= $value['product_info']['ident'] ?>"><i class="far fa-times-circle"></i></span>
                                                    </td>
                                                    
                                            </tr>
                                            <?php
                                        
                                            
                                        }
                                    }            
                                       
                                    ?>
                            </table>
                    </div>
                    
                    <?php if (!empty((new Carts())->getAllProductsFromCart())): ?>
                    
                    <div class="info">
                        <p>ВСЕГО: <span class="red"><span id="cart_amount"><?= Yii::$app->formatter->asDecimal( (new Carts())->getTotalProductsPricesCurrencyCart(), 2);?></span> ГРН</span></p>
                        <p>ТОВАРОВ: <span class="red cart_count"><?php if (Yii::$app->user->isGuest) { if (isset($_SESSION['cart'])) echo (new Carts())->getTotalProducts(); else echo 0; } else { echo (new Carts())->getTotalProducts(); } ?></span></p>
                    </div>
                    
                    <p class="but first"><span class="cart_erase">ОЧИСТИТЬ КОРЗИНУ</span></p>
                    
                    <?php if ((new Carts())->isIssetBtnImportCart()): ?>
                    <p class="but"><span class="cart_import">ИМПОРТ ИЗ ВРЕМЕННОЙ КОРЗИНЫ</span></p>
                    <?php endif; ?>
                    
                    <div class="clear"></div>
                    
                        <?php
                        $cart = new Carts();
                        if ($cart->isOldCart()):
                        ?>

                        <p class="act_text">Вы создали Корзину более 24 часов назад.</p>
                        <p class="act_text">Чтобы оформить заказ, нажмите кнопку "АКТУАЛИЗИРОВАТЬ КОРЗИНУ".</p>
                        <div class="btn_order">
                            <a href="/act">АКТУАЛИЗИРОВАТЬ КОРЗИНУ</a>
                        </div>

                        <?php
                        else:
                        ?>

                        <div class="btn_order">
                            <a href="/ord">ОФОРМИТЬ ЗАКАЗ</a>
                        </div>

                        <?php endif; ?>
                    <?php endif; ?>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($_SESSION['qqq'])): print_r($_SESSION['qqq']); endif; ?>

<?php
$js = <<<JS
$('p.preloader').hide();
$(document).ajaxStart(function(){
    $('p.preloader').show();
}).ajaxStop(function(){
    $('p.preloader').hide();
});


$('span#del').on("click", function(){
    var id = $(this).attr('class');
    $.ajax({
        url: "/cart-del",
        type: 'post',
        data: {action: 'cart-del', id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
//                $('tr.' + data[1]).hide(350);
//                $('.mes .text').text('Успех! Товар был удален из корзины!');
//                $('.mes').removeClass('red');
//                $('.mes').addClass('green');
//                $('.mes').show(350);
//                if (data[2] == 0)
//                {
//                    $('div.table').css('display', 'none');
//                    $('.cart_empty').css('display', 'block');
//                    $('div.info, p.but.first, .btn_order, .act').css('display', 'none');
//        
//                    $('p.but').css('text-align', 'center');
//                }
//                $('header .cart #cart_count').text('ТОВАРОВ: ' + data[3]);
//                $('header .cart #cart_amount').text(data[4].toFixed(2));
//                $('.top_menu .btns .val').text(data[3]);
//                $('.over_menu .cart #cart_count').text('ТОВАРОВ: ' + data[3]);
//                $('.over_menu .cart #cart_amount').text(data[4].toFixed(2));
//                $('.info #cart_amount').text(data[4].toFixed(2));
//                $('.info .cart_count').text(data[3]);
        
                
            }
            else
            {
                $('.mes .text').text('Ошибка! Товар удалить не удалось!');
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
$('.mes').on("click", function(){
    $(this).hide(350);
});

        
JS;

$this->registerJs($js);
?>


<?php
$js = <<<JS



$('span#rel').on("click", function(){
    var id = $(this).attr('class');
    var count = $(this).parent('td').children('input').val();
        
    var errors = new Array();
        
    if (Number.isInteger(parseInt(count)) && count > 0)
    {

    }
    else
    {
        errors.push('Ошибка! Неправильное количество товара для обновления!');
    }
        
    if (errors.length == 0)
    {
        $.ajax({
            url: "/cart-rel",
            type: 'post',
            data: {action: 'cart-rel', id: id, count: parseInt(count, 10)},
            success: function(data){
                data = data.slice(5);
                data = JSON.parse(data);
                if (data[0] == true)
                {
                    document.location.href = document.location.href;
                }
                else
                {
                    $('.mes .text').text('Ошибка! Товар обновить не удалось!');
        
                    if (data[1] != 'undefined' && data[1] == 'min_order')
                    {
                        $('.mes .text').text('Ошибка! Минимальное количество товара для заказа: ' + data[2] + 'шт!');
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
        $('.mes .text').text(errors[errors.length - 1]);
        $('.mes').removeClass('green');
        $('.mes').addClass('red');
        $('.mes').show(350);
    }
});    
$('.mes').on("click", function(){
    $(this).hide(350);
});

$('.cart table tr input').click(function(){
    if ($('.mes').hasClass('red'))
    {
        $('.mes').hide(350);
    }
});

        
JS;

$this->registerJs($js);
?>


<?php
$js = <<<JS



$('span.cart_erase').on("click", function(){
    $.ajax({
        url: "/cart-erase",
        type: 'post',
        data: {action: 'cart-del'},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                $('tr.' + data[1]).hide(350);
                $('.mes .text').text('Успех! Корзина была очищена!');
                $('.mes').removeClass('red');
                $('.mes').addClass('green');
                $('.mes').show(350);
                $('div.table').css('display', 'none');
                $('.cart_empty').css('display', 'block');
                $('div.info, p.but.first, .btn_order, .act').css('display', 'none');
                $('header .cart #cart_count').text('ТОВАРОВ: 0');
                $('header .cart #cart_amount').text(0);
                $('.top_menu .btns .val').text(0);
                $('.over_menu .cart #cart_count').text('ТОВАРОВ: 0');
                $('.over_menu .cart #cart_amount').text(0);
                $('.info #cart_amount').text(0);
                $('.info .cart_count').text(0);
        
                $('p.but').css('text-align', 'center');
            }
            else
            {
                $('.mes .text').text('Ошибка! Очистить Корзину не удалось!');
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


<?php


$js = <<<JS
$(document).on("click", '.cart_import', function(){

    $.ajax({
        url: "/cart-imp",
        type: 'post',
        data: {action: 'cart-imp'},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
            }
            else
            {
                $('.mes .text').text('Ошибка! Импортировать товары не удалось!');
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