<?php

/* @var $this yii\web\View */

$this->title = 'Список желаний';
//use yii\web\UrlManager;
use frontend\models\user\Messages;
use frontend\models\Menu;
use yii\helpers\Html;
use frontend\models\Carts;
use yii\db\Query;
use frontend\models\PricesList;
use yii\widgets\LinkPager;
?>
<section class="page wishlist">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>СПИСОК ЖЕЛАНИЙ</h2>
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
                    
                    <?php if (empty($models)) echo '<p class="cart_empty" style="display:block">У ВАС НЕТ ТОВАРОВ В СПИСКЕ ЖЕЛАНИЙ</p>'; ?>
                    
                    <p class="mes green">
                        <span class="text">Успех! Корзина была обновлена!</span>
                        <br />
                        <span class="cls">ЗАКРЫТЬ</span>
                    </p>
                    
                    <p class="cart_empty">У ВАС НЕТ ТОВАРОВ В СПИСКЕ ЖЕЛАНИЙ</p>
                    
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
                    
                    <div class="list">
                        <div class="table">
                            <table>
                                <?php if (!empty($models))
                                {
                                ?>
                                    <tr>
                                        <td class="sm_hid">ПРОИЗВОДИТЕЛЬ</td>
                                        <td>НАИМЕНОВАНИЕ</td>
                                        <td>АРТИКУЛ</td>
                                        <td class="sm_hid">НАПРАВЛЕНИЕ</td>
                                        <td>СР. СРОК</td>
                                        <td>НАЛИЧИЕ</td>
                                        <td>МИН. ЗАКАЗ</td>
                                        <td>ВЕС</td>
                                        <td>ЦЕНА</td>
                                        <td></td>
                                    </tr>
                                <?php
                                    $settings = new \frontend\models\Settings();
                                    foreach ($models as $model)
                                    {
                                        $product = json_decode($model['product_info'], true);
//                                        $product = json_decode((new Query())->select(['product_info'])->from($model->product_price_name)->where(['id' => $model->product_id, 'article' => $model->product_article])->limit(1)->one()['product_info']);
//                                        print_r($product); exit();
                                        if (isset($product['article']))
                                        {
                                        ?>

                                        <tr class="<?= $model->id ?>">
                                            <td class="sm_hid"><?= $product['manufacturer'] ?></td>
                                            <td><?= $product['name'] ?></td>
                                            <td><?= $product['article'] ?></td>
                                            <td class="sm_hid"><?= substr($product['this_price_name'], 4) ?></td>
                                            <td><?= (new PricesList())->getPriceListTerm($product['this_price_name']) ?></td>
                                            <td><?= $product['available'] ?> ШТ</td>
                                            <td><span class="for_checked"><?= $product['min_order'] ?></span> ШТ</td>
                                            <td><?= $product['weight'] ?></td>
                                            <td>
                                                <?php
                                                if ( (new PricesList())->getPriceListCurrency($product['this_price_name']) === 'USD' ):
                                                    echo Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($product['product_id'], $product['this_price_name'], $product['article']), 2) . ' ' . (new PricesList())->getPriceListCurrency($product['this_price_name']) . '<br>';
                                                    echo Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($product['product_id'], $product['this_price_name'], $product['article']) * $settings->getCurrencyUSD(), 2) . ' ГРН<br>';
                                                endif;
                                                if ( (new PricesList())->getPriceListCurrency($product['this_price_name']) === 'EURO' ):
                                                    echo Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($product['id'], $product['this_price_name'], $product['article']), 2) . ' ' . (new PricesList())->getPriceListCurrency($product['this_price_name']) . '<br>';
                                                    echo Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($product['id'], $product['this_price_name'], $product['article']) * $settings->getCurrencyEURO(), 2) . ' ГРН<br>';
                                                endif;
                                                if ( (new PricesList())->getPriceListCurrency($product['this_price_name']) === 'UAH' ):
                                                    echo Yii::$app->formatter->asDecimal((new PricesList())->getProductPrice($product['id'], $product['this_price_name'], $product['article']), 2) . ' ГРН<br>';
                                                endif;
                                                
                                                ?>
                                                
                                            </td>
                                            <td>
                                                <input type="text" style="width:29px;text-align:center" value="1">
                                                <span title="Добавить в Корзину" id="add" class="<?= $product['this_price_name'].'^^'.$product['product_id'].'^^'.$product['article']; ?>"><i class="fas fa-cart-plus"></i></span>
                                                <span title="Удалить из &quot;Списка желаний&quot;" id="del" class="<?= $model->id ?>"><i class="far fa-times-circle"></i></span>
                                            </td>
                                        </tr>

                                        <?php
                                        }
                                        else
                                        {
                                           ?>
                                        <tr>
                                            <td colspan="10" class="prod_none">
                                                <?= Html::beginForm(['/search'], 'post', ['target' => '_blank']) ?>

                                                <p>К сожалению, данный товар больше не существует. Вы можете выполнить <?= Html::submitButton('Поиск по коду '.$model['product_article']) ?> данного товара.</p>

                                                <?= Html::input('hidden', 'search', $model['product_article'], ['placeholder' => 'ПОИСК']) ?>

                                                <div class="clear"></div>

                                                <?= Html::endForm(); ?>
                                            </td>
                                        </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>                                        
                            </table>
                        </div>
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
$js = <<<JS



$('span#del').on("click", function(){
    var id = $(this).attr('class');
    $.ajax({
        url: "/wish-del",
        type: 'post',
        data: {action: 'cart-del', id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                $('tr.' + data[1]).hide(350);
                $('.mes .text').text('Успех! Товар был удален из "Списка желаний"!');
                $('.mes').removeClass('red');
                $('.mes').addClass('green');
                $('.mes').show(350);
                if (data[2] == 0)
                {
                    $('div.table').css('display', 'none');
                    $('.cart_empty').css('display', 'block');
                }
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