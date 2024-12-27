<?php

use Slim\App;
use Controllers\BackPackController;
use Controllers\MaterialController;
use Controllers\ItineraryController;

return function (App $app) {

    //Zaino
    $app->get('/backpack', [BackPackController::class, 'getAllBackPackItems']);
    $app->post('/backpack', [BackPackController::class, 'createBackPackItem']);
    $app->put('/backpack/{id}', [BackPackController::class, 'updateBackPackItem']);
    $app->delete('/backpack/{id}', [BackPackController::class, 'deleteBackPackItem']);

    //Materiali
    $app->get('/materials', [MaterialController::class, 'getMaterials']);
    $app->post('/materials', [MaterialController::class, 'createMaterial']);
    $app->put('/materials/{id}', [MaterialController::class, 'updateMaterial']);
    $app->delete('/materials/{id}', [MaterialController::class, 'deleteMaterial']);

    //Percorso
    $app->get('/itinerary', [ItineraryController::class, 'getItineraries']);
    $app->post('/itinerary', [ItineraryController::class, 'createItinerary']);
    $app->put('/itinerary/{id}', [ItineraryController::class, 'updateItinerary']);
    $app->delete('/itinerary/{id}', [ItineraryController::class, 'deleteItinerary']);


};
