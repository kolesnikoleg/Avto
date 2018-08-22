<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Markups */

$this->title = 'Создать наценку';
$this->params['breadcrumbs'][] = ['label' => 'Markups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
