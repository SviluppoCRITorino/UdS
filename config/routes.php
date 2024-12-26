<?php

use Slim\App;
use Controllers\BackPackController;
use Controllers\MaterialController;

return function (App $app) {
    $app->get('/backpack', [BackPackController::class, 'getAllBackPackItems']);
    $app->post('/backpack', [BackPackController::class, 'createBackPackItem']);
    $app->put('/backpack/{id}', [BackPackController::class, 'updateBackPackItem']);
    $app->delete('/backpack/{id}', [BackPackController::class, 'deleteBackPackItem']);

    $app->get('/materials', [MaterialController::class, 'getMaterials']);
    $app->post('/materials', [MaterialController::class, 'createMaterial']);
    $app->put('/materials/{id}', [MaterialController::class, 'updateMaterial']);
    $app->delete('/materials/{id}', [MaterialController::class, 'deleteMaterial']);
};
