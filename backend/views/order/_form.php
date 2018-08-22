<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Status;
use frontend\models\Settings;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    if ($model->user_id == '-1' OR $model->user_id == null OR is_null($model->user_id)) {
        $model->user_id = 'Гость';
    }
    ?>
    <?= $form->field($model, 'user_id')->textInput() ?>

    <?php
    $model->date = Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s');
    ?>
    <?= $form->field($model, 'date')->textInput(['readonly' => 'readonly']) ?>
    
    <?php
    $products = json_decode($model->products, true);
    $dostavka = $products['dostavka_val'];
    ?>
    <p>Доставка: <span class="bold"><?= $dostavka ?></span> грн&nbsp;&nbsp;<a href="#small-dialog-dost" title="Изменить доставку" class="popup-with-zoom-anim dost" id="<?= $model->id ?>">Изменить</a> </p>

    <?php
    $products = json_decode($model->products, true);
                    
    $str = '';

    $str .= '<table class="view_order_products" style="margin-bottom:30px;margin-top:35px">';
        $str .= '<tr class="head">';
            $str .= '<td>Название</td>';
            $str .= '<td>Вес</td>';
            $str .= '<td>Срок</td>';
            $str .= '<td>Мин.заказ</td>';
            $str .= '<td>Валюта</td>';
            $str .= '<td>Производитель</td>';
            $str .= '<td>Количество</td>';
            $str .= '<td>Цена</td>';
            $str .= '<td>Сумма</td>';
            $str .= '<td>Оплачено</td>';
            $str .= '<td>Артикул</td>';
            $str .= '<td>Прайс</td>';
            $str .= '<td></td>';

        $str .= '</tr>';

        foreach ($products as $key => $product)
        {
            if ($key !== "total_price" AND $key !== "total_payed" AND $key !== "dostavka_val") {

                $str .= '<tr>';
                    $str .= '<td>' . $product['name'] . '</td>';
                    $str .= '<td>' . $product['weight'] . '</td>';
                    $str .= '<td>' . $product['term'] . '</td>';
                    $str .= '<td>' . $product['min_order'] . '</td>';
                    $str .= '<td>' . $product['currency'] . '</td>';
                    $str .= '<td>' . $product['manufacturer'] . '</td>';
                    $str .= '<td>' . $product['count'] . '</td>';
                    $str .= '<td>' . $product['price'] . '</td>';
                    $str .= '<td>' . $product['price'] * $product['count'] . '</td>';
                    $str .= '<td>' . $product['payed'] . '</td>';
                    $str .= '<td>' . $product['article'] . '</td>';

                    if (substr($product['price_list'], 0, 4) == (new Settings())->getPricelistsPrefix()) {                            
                        $str .= '<td>' . substr($product['price_list'], 4) . '</td>';
                    }
                    else
                    {
                        $str .= '<td>' . $product['price_list'] . '</td>';
                    }
                    
                    $str .= '<td>';
                    $str .= '<a title="Удалить товар" class="delete" id="'.$key.'^^'.$model->id.'"><i class="fas fa-times-circle"></i></span>';
                    $str .= '<a href="#small-dialog-pay" title="Провести оплату" class="popup-with-zoom-anim pay" id="'.$key.'^^'.$model->id.'"><i class="fas fa-dollar-sign"></i></span>';
                    $str .= '<a href="#small-dialog-count" title="Изменить количество" class="popup-with-zoom-anim count" id="'.$key.'^^'.$model->id.'"><i class="fas fa-cubes"></i></span>';
                    $str .= '</td>';

                $str .= '</tr>';

            }
        }

    $str .= '</table>';
    
    echo $str;
    ?>
    
    <p style="text-align:right">Общая сумма заказа: <span class="bold"><?= $products['total_price'] ?></span> грн</p>
    
    <?php
    if ($model->dostavka == -1): $model->dostavka = ''; endif;
    ?>
    <?= $form->field($model, 'dostavka')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'status')->dropdownList(
        Status::find()->select(['text', 'id'])->indexBy('id')->column()
    ); ?>
    
    <?php 
    if ($model->status != -1) {
        $model->admin_status = (new Query())
                                    ->select(['username'])
                                    ->from('admin')
                                    ->where(['id' => $model->admin_status])
                                    ->limit(1)
                                    ->one()['username'];
        echo $form->field($model, 'admin_status')->textInput(['readonly' => 'readonly']);
    }
    ?>
    
    <?php 
    if ($model->status != -1) {
        $model->date_status = Yii::$app->formatter->asDatetime($model->date_status, 'php:d.m.Y H:i:s');
        echo $form->field($model, 'date_status')->textInput(['readonly' => 'readonly']);
    }
    ?>

    <?php 
    if ($model->client_comment == '-1' OR $model->client_comment == null OR is_null($model->client_comment)) {
        $model->client_comment = '';
    }
    ?>
    <?= $form->field($model, 'client_comment')->textarea(['rows' => 2]) ?>

    <?php 
    if ($model->admin_comment == '-1' OR $model->admin_comment == null OR is_null($model->admin_comment) OR $model->admin_comment == '') {
        $model->admin_comment = '';
    }
    ?>
    <?= $form->field($model, 'admin_comment')->textarea(['rows' => 2]) ?>

    <?php
    if ($model->admin_comment == '-1' OR $model->admin_comment == null OR is_null($model->admin_comment) OR $model->admin_comment == '') {
    }
    else
    {
        $model->date_admin_comment = Yii::$app->formatter->asDatetime($model->date_status, 'php:d.m.Y H:i:s');
        echo $form->field($model, 'date_admin_comment')->textInput(['readonly' => 'readonly']);
    }
    ?>

    <?php 
    if ($model->admin_comment == '-1' OR $model->admin_comment == null OR is_null($model->admin_comment) OR $model->admin_comment == '') {
    }
    else
    {
        $model->who_admin_comment = (new Query())
                                    ->select(['username'])
                                    ->from('admin')
                                    ->where(['id' => $model->who_admin_comment])
                                    ->limit(1)
                                    ->one()['username'];
        echo $form->field($model, 'who_admin_comment')->textInput(['readonly' => 'readonly']);
    }
    ?>
    
    <?= $form->field($model, 'admin_archive')->dropdownList(['-1' => 'Нет', '2' => 'Да']); ?>
    
    <?= $form->field($model, 'user_archive')->dropdownList(['-1' => 'Нет', '2' => 'Да']); ?>

    <?php 
    if ($model->date_changed != -1 AND $model->date_changed != '') {
        $model->date_changed = Yii::$app->formatter->asDatetime($model->date_changed, 'php:d.m.Y H:i:s');
        echo $form->field($model, 'date_changed')->textInput(['readonly' => 'readonly']);
    }
    ?>

    <?php 
    if ($model->who_admin_changed != -1 AND $model->who_admin_changed != '') {
        echo $form->field($model, 'who_admin_changed')->textInput(['readonly' => 'readonly']);
    }
    ?>
    
    <?php echo $form->field($model, 'user_delete')->dropdownList(['-1' => 'Нет', '2' => 'Да']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
