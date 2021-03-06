<?php

use yii\helpers\Html;
use frontend\models\PricesList;
use yii\db\Query;

$this->title = 'Новым клиентам';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page new-client">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>НОВЫМ КЛИЕНТАМ</h2>
                
                <?php
                echo (new Query())
                        ->select(['text'])
                        ->from('settings')
                        ->where(['type' => 'new_client_page'])
                        ->limit(1)
                        ->one()['text'];
                ?>
               
            </div>
        </div>
    </div>
</section>