<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
	$app->get('/customers-data/all', \App\Action\HomeAction::class);
};

