<?php
return [
    'name'          => 'Payment for delivery upon receipt',
    'description'   => 'Ability to hide the delivery cost in an order so that when paying online the client pays only for the order without delivery',
    'img'           => 'img/icon16.png',
    'version'       => '1.2.0',
    'vendor'        => '670917',
    'shop_settings' => true,
    'handlers'      => [
        'order_action.create' => 'handlerOrderAction',
        'order_action.edit'   => 'handlerOrderAction',
        'backend_order'       => 'handlerBackendOrder'
    ],
];
