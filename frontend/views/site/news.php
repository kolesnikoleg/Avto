<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page news">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>НОВОСТИ</h2>
                
                <div class="row">
                    
                    <?php foreach ($models as $new): ?>
                    <div class="col-xs-12 nws">
                            <p class="header"><?= $new['title'] ?></p>
                            <p class="date">ДОБАВЛЕНО: <?= Yii::$app->formatter->asDate($new['date'], "php:d.m.Y") ?></p>
                            <p class="content"><?= $new['content'] ?></p>
                    </div>
                    <?php endforeach ?>
                    
                </div>
                
                <?php
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
                
            </div>
        </div>
    </div>
</section>