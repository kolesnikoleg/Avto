<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Создать клиента';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $model->created_at = Yii::$app->formatter->asTimestamp('now');
    $model->updated_at = Yii::$app->formatter->asTimestamp('now');
    $model->balance = 0;
    $model->total_balance_plus = 0;
    $model->skidka_val = 0;
    $model->auth_key = Yii::$app->security->generateRandomString();
    ?>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
