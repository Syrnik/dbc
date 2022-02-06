<?php
return [
    'name'          => 'Оплата доставки при получении',
    'description'   => 'Возможность скрыть стоимость доставки в заказе так, чтобы при оплате онлайн клиент оплатил только заказ без доставки',
    'img'           => 'img/icon16.png',
    'version'       => '1.1.0',
    'vendor'        => '670917',
    'shop_settings' => true,
    'handlers'      => [
        'order_action.create' => 'handlerOrderAction',
        'order_action.edit'   => 'handlerOrderAction',
        'backend_order'       => 'handlerBackendOrder'
    ],
];
