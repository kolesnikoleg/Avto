<?php

use yii\helpers\Html;

$this->title = 'Новым клиентам';
$this->params['breadcrumbs'][] = $this->title;

//if (!isset($search_str)): $search_str = []; endif;
//if (!isset($tbls)): $tbls = ''; endif;
//$search_str = '';
//$tbls = [];
?>
<section class="page" id="search_res">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <?php
                if (isset($search_str))
                {
                ?>
                
                
                
                <h2>РЕЗУЛЬТАТЫ ПОИСКА ПО КОДУ</h2>
                <p class="under_head"><?= $search_str ?></p>

                <p class="found">НАЙДЕНО <span class="red"><span class="total_found">0</span></span> <span class="offer_str">ПРЕДЛОЖЕНИЯ</span> ОТ <span class="red"><span class="price_min">999999999999</span> ГРН</span> ДО <span class="red"><span class="price_max">0</span> ГРН</span></p>
                
                <p class="mes green">
                    <span class="text">Успех! Корзина была обновлена!</span>
                    <br />
                    <span class="cls">ЗАКРЫТЬ</span>
                </p>
                
                <p class="preloader">
                    <img src="img/pre.gif">
                </p>

                <div class="new_search" id="search_res">
                    <div class="table">
                            <div class="header">ЗАПРАШИВАЕМЫЙ ТОВАР</div>
                            <table>
                                    <tr>
                                            <td class="sm_hid">ПРОИЗВОДИТЕЛЬ</td>
                                            <td>НАИМЕНОВАНИЕ</td>
                                            <td>АРТИКУЛ</td>
                                            <td class="sm_hid">НАПРАВЛЕНИЕ</td>
                                            <td>СР. СРОК</td>
                                            <td>ЦЕНА</td>
                                            <td>ПР. ВЕС</td>
                                            <td>МИН. ПАРТИЯ</td>
                                            <td>НАЛИЧИЕ</td>
                                            <td></td>
                                    </tr>
                                    
                                   
                                    
                                    
                                    
                                    
                            </table>
                    </div>
                    
                    <p class="not_found">К СОЖАЛЕНИЮ, ПО ВАШЕМУ ЗАПРОСУ НИЧЕГО НЕ НАЙДЕНО!</p>
                
                </div>
                
                <?php
                }
                else
                {
                ?>
                    <h2>ОШИБКА! ВЫ НЕ ВВЕЛИ ПОИСКОВЫЙ ЗАПРОС!</h2>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
//for ($i = 0; $i < 500000; $i++)
//{
//    Yii::$app->db->createCommand("INSERT INTO `yii2advanced`.`prc_USA` (`manufacturer`, `name`, `article`, `count`, `weight`, `min_order`, `price`, `this_price_name`) VALUES ('FORD', 'Компрессор коленвала', '".rand(265918, 1548625154)."', '".rand(1, 50)."', '5.26', '1', '".rand(10, 3000)."', 'prc_USA')")->execute();
//
//  
//}



if (isset($search_str))
{
                

$js = <<<JS
        
$(document).ajaxStart(function(){
    $('p.preloader').show();
}).ajaxStop(function(){
    $('p.preloader').hide();
        
    if ($('.total_found').text() == 0)
    {
        $('p.not_found').css('display','block');
    }
});
        
function search(tbl_name, api)
{
    if (api === undefined) {
        var api = '-1';
    }
        
    $.ajax({
            url: "/search-result",
            type: 'post',
            data: {action: 'search', tbl: tbl_name, api: api, search_string: '$search_str'},
            success: function(data){
                    data = data.substr(5);
                    data = JSON.parse(data);
                    if (data)
                    {
                        for (i = 0; i < data.length; i++)
                        {
                            var append_str = '';

                            append_str = append_str + '<tr>';
        
                            if (data[i].manufacturer == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].manufacturer + '</td>';
                            }
        
                            if (data[i].name == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].name + '</td>';
                            }
        
                            if (data[i].article == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].article + '</td>';
                            }
        
                            if (data[i].this_price_name == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].this_price_name.substr(4) + '</td>';
                            }
        
                            if (data[i].term == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].term + '</td>';
                            }
        
                            if (data[i].price == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].price + '</td>';
                            }
        
                            if (data[i].weight == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].weight + '</td>';
                            }
        
                            if (data[i].min_order == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td><span class="for_checked">' + data[i].min_order + '</span> ШТ</td>';
                            }
        
                            if (data[i].count == undefined)
                            {
                                append_str = append_str + '<td>' + '-' + '</td>';
                            }
                            else
                            {
                                append_str = append_str + '<td>' + data[i].count + ' ШТ</td>';
                            }
        
                            append_str = append_str + '<td>' + '<input type="text" style="width:29px;text-align:center" value="1"><span id="add" class="' + data[i].this_price_name + '^^' + data[i].id + '^^' + data[i].article + '^^' + data[i].price_null + '"><i class="fas fa-cart-plus"></i></span>' + '</td>';
                            append_str = append_str + '</tr>';
                            $('.new_search table').append(append_str);
        
                            $('.total_found').text($('.new_search table tr').length - 1);
        
                            if (parseFloat($('.price_min').text()) > parseFloat(data[i].price_uah)) { $('.price_min').text(data[i].price_uah.toFixed(2)); }
                            if (parseFloat($('.price_max').text()) < parseFloat(data[i].price_uah)) { $('.price_max').text(data[i].price_uah.toFixed(2)); }
                            $('.found').css('display','block');
                            $('div.table').css('display', 'block');
        
                            if ($('.new_search table tr').length - 1 > 9 && $('.new_search table tr').length - 1 < 21)
                            {
                                $('.offer_str').text('ПРЕДЛОЖЕНИЙ');
                            }
                            else
                            {
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 1) { $('.offer_str').text('ПРЕДЛОЖЕНИЕ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 2) { $('.offer_str').text('ПРЕДЛОЖЕНИЯ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 3) { $('.offer_str').text('ПРЕДЛОЖЕНИЯ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 4) { $('.offer_str').text('ПРЕДЛОЖЕНИЯ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 5) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 6) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 7) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 8) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 9) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                                if (($('.new_search table tr').length - 1).toString().substr(-1) == 0) { $('.offer_str').text('ПРЕДЛОЖЕНИЙ'); }
                            }
                        }
                    }	
                    
                    if (data == '<?php')
                    {
                        alert('Произошла ошибка! Попробуйте позже!');
                    }	
            },
            error: function(error){
                    alert('Ошибка AJAX: ' + error);
            },
            // dataType: 'html'
    });
}
        

JS;

$js .= "var arr = [";

foreach ($tbls as $key => $value)
{
    $js .= "'".$value."', ";
}

$js = substr($js, 0, -1);

$js .= "];";

$js .= "for (i = 0; i < arr.length; i++)
{
    search(arr[i]);
}

";
//---------------------------------
$js .= "var arr_apis = [";

foreach ($apis as $key => $value)
{
    $js .= "'".$value['id']."', ";
}

$js = substr($js, 0, -1);

$js .= "];";

$js .= "for (i = 0; i < arr_apis.length; i++)
{
    search('', arr_apis[i]);
}

";


$this->registerJs($js);


}