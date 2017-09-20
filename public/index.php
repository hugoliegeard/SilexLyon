<?php

use Silex\Application;
use TechNews\Provider\NewsControllerProvider;
use TechNews\Provider\AdminControllerProvider;

#1 : Importation de l'Autoloader
require_once __DIR__.'/../vendor/autoload.php';

#2 : Instanciation de l'Application
$app = new Application();

#3 : Activation du Debuggage
$app['debug'] = true;

#4 : Gestion de Nos Controllers
$app->mount('/', new NewsControllerProvider());
$app->mount('/admin', new AdminControllerProvider());

#5 : Execution de l'Application
$app->run();













