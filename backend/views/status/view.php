<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Status */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-view">

    <h1>Просмотр статуса "<?= Html::encode($model->text) ?>"</h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'text',
            'text_color',
            'bg_color',
        ],
    ]) ?>

</div>
