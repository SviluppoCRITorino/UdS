<?php
use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Carica le configurazioni
$settings = require __DIR__ . '/../config/settings.php';
$dependencies = require __DIR__ . '/../config/dependencies.php';

// Configura il container
$container = new Container();

$container->set('settings', $settings['settings']);

foreach ($dependencies as $key => $value) {
    $container->set($key, $value);
}
AppFactory::setContainer($container);

// Crea l'app
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

// Carica le rotte
(require __DIR__ . '/../config/routes.php')($app);

$app->run();

