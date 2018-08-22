<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricesListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прайсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Прайс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'name',
                'value' => function ($model) {
                    return substr($model->name, 4);
                },
            ],
            'term',
            'currency',
            [
                'attribute' => 'date',
                'value' => function ($model) {
//                    Yii::$app->setTimeZone('Europe/Kiev');
//                    return Yii::$app->formatter->asDatetime($model->date, "php:d.m.Y H:i:s");
                    return $model->date;
                },
            ],
            'rows',
            [
                'attribute' => 'Строк по факту',
                'value' => function ($model) {
                    return (new Query())->select(['id'])->from($model->name)->count();
                },
                'contentOptions' => function ($model) {
                    if (($model->rows <= (new Query())->select(['id'])->from($model->name)->count()) AND ($model->rows !== 0)){
                        return ['style' => 'background-color:green;color:white'];
                    } else {
                        return ['style' => 'background-color:red;color:white'];
                    }
                    
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>