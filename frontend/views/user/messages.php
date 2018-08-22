<?php

/* @var $this yii\web\View */

$this->title = 'Мои сообщения';
//use yii\web\UrlManager;
use frontend\models\user\Messages;
use frontend\models\Menu;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<section class="page messages">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>МОИ СООБЩЕНИЯ</h2>
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
                    
                    <?php if (empty($models)) echo '<p class="cart_empty" style="display:block">У ВАС НЕТ СООБЩЕНИЙ</p>'; ?>
                    
                    <div class="content">
                        <?php
                        foreach ($models as $model)
                        {
                            ?>
                            <div class="one">
                                <p class="head">СООБЩЕНИЕ <?= $model->id ?></p>
                                <div class="text"<?php if ($model->readed === 2): echo ' style="background-color:#DDD"'; endif; ?>>
                                    <p>ДАТА: <?= Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i')?></p>
                                    <p class="last">ТЕКСТ СООБЩЕНИЯ: <?= $model->text ?></p>
                                    <?php if ($model->readed === -1): ?>
                                    <p class="readed"><span id="<?= $model->id ?>">ПОМЕТИТЬ КАК ПРОЧИТАННОЕ</span></p>
                                    <?php endif; ?>
                                    <p class="del"><span class="del">УДАЛИТЬ СООБЩЕНИЕ</span><span class="del_confirm" id="<?= $model->id ?>">ТОЧНО УДАЛИТЬ</span></p>
                                </div>
                            </div>
                            <?php
                        }
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
$js = <<<JS
    
$('.content p.del span.del').click(function(){
    if ($(this).parents('p.del').children('.del_confirm').css('display') == 'none')
    {
        $(this).parents('p.del').children('.del_confirm').fadeIn(400);
    }
    else
    {
        $(this).parents('p.del').children('.del_confirm').fadeOut(400);
    }
}); 
        
$('.content p.readed span').on("click", function(){
    var id = $(this).attr('id');
        
    $.ajax({
        url: "/mes-read",
        type: 'post',
        data: {id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
            }
            else
            {
                document.location.href = document.location.href;
            }
        },
        error: function(error){
            alert('Ошибка Ajax: ' + error);
        },
        dataType: 'text'
    });
});
        
$('.content p.del .del_confirm').on("click", function(){
    var id = $(this).attr('id');
        
    $.ajax({
        url: "/mes-del",
        type: 'post',
        data: {id: id},
        success: function(data){
            data = data.slice(5);
            data = JSON.parse(data);
            if (data[0] == true)
            {
                document.location.href = document.location.href;
            }
            else
            {
                document.location.href = document.location.href;
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