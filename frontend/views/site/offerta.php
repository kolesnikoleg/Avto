<?php

use yii\helpers\Html;
use frontend\models\Product;
use frontend\models\Carts;
use frontend\models\Api;
use yii\db\Query;
//use SoapClient;

$this->title = 'Оплата и доставка';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page new-client">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>ПУБЛИЧНАЯ ОФЕРТА</h2>
                
                <?php
                echo (new Query())
                        ->select(['text'])
                        ->from('settings')
                        ->where(['type' => 'offerta_page'])
                        ->limit(1)
                        ->one()['text'];
                ?>
                
            </div>
        </div>
    </div>
</section>