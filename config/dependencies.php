<?php
use Psr\Container\ContainerInterface;

use Services\BackPackService;
use Controllers\BackPackController;

use Services\MaterialService;
use Controllers\MaterialController;

return [
    'db' => function (ContainerInterface $c) {
        $settings = $c->get('settings')['db'];
        $dsn = "mysql:host={$settings['host']};dbname={$settings['dbname']};charset=utf8mb4";
        return new PDO($dsn, $settings['user'], $settings['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    },

    BackPackService::class => function (ContainerInterface $c) {
        return new BackPackService($c->get('db'));
    },

    BackPackController::class => function (ContainerInterface $c) {
        return new BackPackController($c->get(BackPackService::class));
    },

    MaterialService::class => function (ContainerInterface $c) {
        return new MaterialService($c->get('db'));
    },

    MaterialController::class => function (ContainerInterface $c) {
        return new MaterialController($c->get(MaterialService::class));
    },
];
