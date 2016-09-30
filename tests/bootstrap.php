<?php

require __DIR__ . '/../vendor/autoload.php';

// constants
define('USER_FILES_DIR_NAME', 'testsUserFiles');
define('USER_FILES_DIR', __DIR__ . '/../temp/' . USER_FILES_DIR_NAME);
define('FORM_TEMPLATES_DIR', __DIR__ . '/../app/forms');
define('CONFIG_DIR', __DIR__ . '/../app/config');
define('RESOURCES_DIR', __DIR__ . '/resources');

Tester\Environment::setup();

$configurator = new Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../app')
	->register();

$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
return $configurator->createContainer();
