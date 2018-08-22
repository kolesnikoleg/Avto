<?php

use yii\helpers\Html;
use yii\db\Query;

$this->title = 'График заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page new-client">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>ГРАФИК ЗАКАЗОВ</h2>
                
                <?php
                echo (new Query())
                        ->select(['text'])
                        ->from('settings')
                        ->where(['type' => 'graphic_page'])
                        ->limit(1)
                        ->one()['text'];
                ?>
                
            </div>
        </div>
    </div>
</section>