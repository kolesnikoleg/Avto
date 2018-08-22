<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Messages */

$this->title = 'Создать сообщение';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
