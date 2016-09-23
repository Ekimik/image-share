<?php

require __DIR__ . '/../vendor/autoload.php';

// constants
define('USER_FILES_DIR', __DIR__ . '/../www/userFiles');
define('FORM_TEMPLATES_DIR', __DIR__ . '/../app/forms');

Tester\Environment::setup();

$configurator = new Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../app')
	->register();

$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
return $configurator->createContainer();
