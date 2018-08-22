<?php

use yii\helpers\Html;
use yii\db\Query;

$this->title = 'F.A.Q.';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page news">
    <div class="container">
	<div class="row">
            <div class="col-xs-12">
                <h2>F.A.Q.</h2>
                
                <?php
                $faqs = (new Query())
                            ->select(['*'])
                            ->from('faq')
                            ->orderBy('order ASC')
                            ->all();
                
                $i = 1;
                ?>
                
                <div class="row">
                    
                    <?php foreach ($faqs as $faq): ?>
                 
                    <div class="col-xs-12 nws">
                            <p class="header"><?= $i ?>. <?= $faq['question'] ?></p>
                            <p class="content"><?= $faq['answer'] ?></p>
                    </div>
                
                    <?php $i++; endforeach; ?>
                    
                </div>
                
            </div>
        </div>
    </div>
</section>