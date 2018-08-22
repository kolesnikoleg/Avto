<?php
return [
    'adminEmail' => 'admin@example.com',
    'maxNewsInList' => 2,
    'shortTextLimit' => 20,
    'main_menu' => [
        'Главная' => '/',
        'Новым клиентам' => '/new-client',
        'График заказов' => '/graphic',
        'Оплата и доставка' => '/oplata-i-dostavka',
        'F.A.Q.' => '/faq',
        'Новости' => '/news',
        'Контакты' => '/contacts',
        'Еще' => [
            'Связаться с нами' => '/contact-us',
            'Написать нам' => '/contact-us',
            'Позвонить нам' => '/contact-us'
        ]
    ],
    'my_menu' => [
        'Личный кабинет' => '/user/index',
        'Мои заказы' => '/user/orders',
        'Архив заказов' => '/user/archive',
        'История баланса' => '/user/transaction',
//        'Список желаний' => '/user/wishlist',
        'Мои автомобили' => '/user/my-cars/index',
        'Мои сообщения' => '/user/messages',
        'Адрес доставки' => '/user/address',
        'Настройки' => '/user/settings',
    ],
    'dop_menu' => [
        'stock' => '/stock',
        'price' => '/price',
        'vin' => '/vin',
    ]
];
