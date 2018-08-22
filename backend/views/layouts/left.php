<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->admin->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        
        <?php
        if (Yii::$app->admin->identity->username == 'admin1' OR Yii::$app->admin->identity->username == 'admin2') {
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Админы', 'icon' => 'file-code-o', 'url' => ['/admin']],
                ],
            ]
        );
        } ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Главное меню', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/user']],
                    ['label' => 'Заказы', 'icon' => 'clipboard', 'url' => ['/order']],
                    ['label' => 'Корзины', 'icon' => 'shopping-cart', 'url' => ['/cart']],
                    ['label' => 'API', 'icon' => 'file-code-o', 'url' => ['/api']],
                    ['label' => 'Наценки', 'icon' => 'dollar-sign', 'url' => ['/markups']],
                    ['label' => 'Сообщения', 'icon' => 'envelope', 'url' => ['/messages']],
                    ['label' => 'Новости', 'icon' => 'newspaper', 'url' => ['/news']],
                    ['label' => 'Прайс-листы', 'icon' => 'file-alt', 'url' => ['/prices-list']],
                    ['label' => 'Настройки', 'icon' => 'cogs', 'url' => ['/settings']],
                    ['label' => 'Статусы', 'icon' => 'battery-half', 'url' => ['/status']],
                    ['label' => 'Транзакции', 'icon' => 'hand-point-right', 'url' => ['/transaction']],
                    ['label' => 'VIN-запросы', 'icon' => 'car', 'url' => ['/vin']],
                    ['label' => 'FAQ', 'icon' => 'question-circle', 'url' => ['/faq']],
                    ['label' => 'Выход', 'icon' => 'times-circle', 'url' => ['/site/logout']],
//                    [
//                        'label' => 'Some tools',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ],
            ]
        ) ?>
        
        
        
        

    </section>

</aside>
