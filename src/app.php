<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

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
$app->register(new AssetServiceProvider());

#6 : Importation pour les Formulaires
$app->register(new FormServiceProvider());
$app->register(new CsrfServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'translator.domains' => array(), 
));

#7 : Doctrine DBAL et Idiorm (BDD)
require PATH_RESSOURCES . '/config/database.config.php';

#8 : Sécurisation de notre Application
require PATH_RESSOURCES . '/config/security.php';

#9 : On retourne $app
return $app;


















