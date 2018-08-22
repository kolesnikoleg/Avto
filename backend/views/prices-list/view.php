<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\PricesList;

/* @var $this yii\web\View */
/* @var $model backend\models\PricesList */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Prices Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'term',
            'currency',
//            'rows',
        ],
    ]) ?>
    
    <div class="row prclst">
        <?php // $form = Form::begin(['id' => 'contact-form', 'options' => ['action' => 'add-price', 'class' => 'myform', 'name' => 'upload_excel', 'enctype' => 'multipart/form-data']]); ?>
        <?= Html::beginForm(['/site/add-price'], 'post',  ['class' => 'myform', 'name' => 'upload_excel', 'enctype' => 'multipart/form-data']) ?>
    <!--<form class="form-horizontal" action="/add-price" method="post" name="upload_excel" enctype="multipart/form-data">-->
        <fieldset>

            <!-- Form Name -->
            <legend>Form Name</legend>

            <!-- File Button -->
            <div class="form-group">
                <label class="col-md-12 control-label" for="filebutton">Выберите прайс:</label>
                <div class="col-md-12">
                    <select name="pricelist">
                        <option>Не указано!</option>
                        <?php
                        $prices = (new PricesList())->getListPricesAll();
                        foreach ($prices as $price)
                        {
                            ?>
                            <option><?= substr($price, 4); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- File Button -->
            <div class="form-group">
                <label class="col-md-12 control-label" for="filebutton">Select File</label>
                <div class="col-md-12">
                    <input type="file" name="file" id="file" class="input-large">
                </div>
            </div>

            <!-- File Button -->
            <div class="form-group">
                <label class="col-md-12 control-label" for="filebutton">Производитель:</label>
                <div class="col-md-12">
                    <input type="text" name="manufacturer" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Артикул:</label>
                <div class="col-md-12">
                    <input type="text" name="article" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Название:</label>
                <div class="col-md-12">
                    <input type="text" name="name" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Наличие:</label>
                <div class="col-md-12">
                    <input type="text" name="count" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Вес:</label>
                <div class="col-md-12">
                    <input type="text" name="weight" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Минимальный заказ:</label>
                <div class="col-md-12">
                    <input type="text" name="min_order" class="input">
                </div>
                <label class="col-md-12 control-label" for="filebutton">Цена:</label>
                <div class="col-md-12">
                    <input type="text" name="price" class="input">
                </div>
            </div>


            <!-- Button -->
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Импорт</button>
                </div>
            </div>

        </fieldset>
    <?= Html::endForm(); ?>


</div>

</div>
