<?php
return [
    'name'          => 'Оплата доставки получателем',
    'img'           => 'img/dbc.gif',
    'version'       => '1.0.0',
    'vendor'        => '670917',
    'shop_settings' => true,
    'handlers'      => [
        'order_action.create' => 'handlerOrderAction',
        'order_action.edit'   => 'handlerOrderAction',
        'backend_order'       => 'handlerBackendOrder'
    ],
];
