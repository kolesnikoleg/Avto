<?php

/* @var $this yii\web\View */

$this->title = 'История транзакций';
//use yii\web\UrlManager;
use frontend\models\user\Messages;
use frontend\models\Menu;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<section class="page transaction">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>ИСТОРИЯ ТРАНЗАКЦИЙ</h2>
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
                    
                    <?php if (empty($models)) echo '<p class="cart_empty" style="display:block">У ВАС НЕТ ТРАНЗАКЦИЙ</p>'; ?>
                    
                    <div class="content">
                        <?php
                        foreach ($models as $model)
                        {
                            ?>
                            <div class="one">
                                <p class="head">ТРАНЗАКЦИЯ <?= $model->id ?></p>
                                <div class="text">
                                    <p>ДАТА: <?= Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i')?></p>
                                    <p><?php if ($model->math_op == '+'): echo 'ОПЕРАЦИЯ: "+'.$model->value.' ГРН" ПОПОЛНЕНИЕ БАЛАНСА'; else: echo 'ОПЕРАЦИЯ: "-'.$model->value.' ГРН"' . ($model->order_id != '-1' ? ' ОПЛАТА ЗАКАЗА '.$model->order_id : ' СНЯТО С БАЛАНСА'); endif;?></p>
                                    <p><?php if ($model->comment_for_user != '' AND $model->comment_for_user != '-1'): echo 'КОММЕНТАРИЙ: '.$model->comment_for_user; endif; ?></p>
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