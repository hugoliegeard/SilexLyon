<?php

use Silex\Provider\AssetServiceProvider;

#1 : Activation du Debuggage
$app['debug'] = true;

#2 : Gestion de Nos Controllers
require PATH_SRC . '/routes.php';

#3 : Activation de Twig
# : composere require twig/twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        __DIR__.'/../ressources/views',
        __DIR__.'/../ressources/layout'
    ]
));

#4 : Ajout des Extentions TechNews pour Twig
$app->extend('twig', function($twig, $app) {
    $twig->addExtension(new \TechNews\Extension\TechNewsTwigExtension());
    return $twig;
});
    
#5 : Activation de Asset
# : use Silex\Provider\AssetServiceProvider;
$app->register(new AssetServiceProvider());

#6 : Doctrine DBAL et Idiorm (BDD)
require PATH_RESSOURCES . '/config/database.config.php';

#7 : Sécurisation de notre Application
require PATH_RESSOURCES . '/config/security.php';

# 8 : On retourne $app
return $app;


















