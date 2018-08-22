<?php use yii\db\Query ?>

<div class="row">
    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>НОВЫЕ КЛИЕНТЫ</h3>

                <p>СЕГОДНЯ: <?= (new Query())->select(['id'])->from('user')->where(['>=', 'created_at', strtotime('today midnight')])->count() ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-home"></i>
            </div>
            <a href="<?= \yii\helpers\Url::to('user') ?>" class="small-box-footer">Клиенты <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->


    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>НОВЫЕ ЗАКАЗЫ</h3>

                <p>СЕГОДНЯ: <?= (new Query())->select(['id'])->from('order')->where(['>=', 'date', date("Y-m-d 00:00:00")])->count() ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= \yii\helpers\Url::to(['/order']) ?>" class="small-box-footer">Заказы <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->

    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>НОВЫЕ КОРЗИНЫ</h3>

                <p>СЕГОДНЯ: <?= (new Query())->select(['user_id'])->distinct()->from('carts')->where(['>=', 'start_cart', date("Y-m-d 00:00:00")])->count() ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= \yii\helpers\Url::to(['/cart']) ?>" class="small-box-footer">Корзины <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
    <!-- ./col -->

    <div class="col-md-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>НЕЗАКОНЧЕННЫЕ ПРАЙСЫ</h3>

                <?php
                $prices = (new Query())->select(['*'])->from('prices_list')->all();
                $broken_prices = 0;
                foreach ($prices as $price) {
                    if ($price['rows'] > (new Query())->select('id')->from($price['name'])->count()) {
                        $broken_prices++;
                    }
                }
                ?>
                
                <p>Всего: <?= $broken_prices ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-grid"></i>
            </div>
            <a href="<?= \yii\helpers\Url::to(['/prices-list']) ?>" class="small-box-footer">Прайсы <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->

</div>

<div class="row">
    <div class="col-sm-12">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Languages</h3>
            </div>
            <div class="box-body">
                Test
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <small>Registered in <code>urlManager</code> application component.</small>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>

</div>


<div class="row">
    <div class="col-sm-6">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Modules</h3>
            </div>
            <div class="box-body">
                <?php
                foreach (\Yii::$app->getModules() AS $name => $m) {
                    $module = \Yii::$app->getModule($name);
                    echo yii\helpers\Html::a(
                        $module->id,
                        ['/'.$module->id],
                        ['class' => 'btn btn-default btn-flat']
                    );
                }
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <small>Registered in application from configuration or bootstrapping.</small>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-sm-6">
        <!-- Default box -->
        <div class="box box-solid box-warning">
            <div class="box-header">
                <h3 class="box-title">Documentation</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    <i class="fa fa-warning"></i>
                    <b>Notice!</b> Use the <i>yii2-apidoc</i> extension to
                    create the HTML documentation for this application.
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>
</div>

<?php //phpinfo() ?>