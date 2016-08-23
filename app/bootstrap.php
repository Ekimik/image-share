<?php

require __DIR__ . '/../vendor/autoload.php';

// constants
define('USER_FILES_DIR', __DIR__ . '/../www/userFiles');
define('FORM_TEMPLATES_DIR', __DIR__ . '/forms');

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
//$configurator->addConfig(__DIR__ . '/config/fb.neon');

$router = new \Nette\Application\Routers\RouteList();
$router[] = new Nette\Application\Routers\Route('<presenter>/<action>[/<id>]', 'Default:default');

$container = $configurator->createContainer();

$container->addService('router', $router);

return $container;
