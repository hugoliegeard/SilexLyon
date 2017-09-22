<?php

use Silex\Application;
use TechNews\Provider\NewsControllerProvider;
use TechNews\Provider\AdminControllerProvider;
use Silex\Provider\AssetServiceProvider;

#1 : Importation de l'Autoloader
require_once __DIR__.'/../vendor/autoload.php';

#2 : Instanciation de l'Application
$app = new Application();

#3 : Activation du Debuggage
$app['debug'] = true;

#4 : Gestion de Nos Controllers
$app->mount('/', new NewsControllerProvider());
$app->mount('/admin', new AdminControllerProvider());

#5.1 : Activation de Twig
 # : composere require twig/twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        __DIR__.'/../ressources/views',
        __DIR__.'/../ressources/layout'
    ]
));

#5.2 : Ajout des Extentions TechNews pour Twig
$app->extend('twig', function($twig, $app) {
    $twig->addExtension(new \TechNews\Extension\TechNewsTwigExtension());
    return $twig;
});

#6 : Activation de Asset
 # : use Silex\Provider\AssetServiceProvider;
$app->register(new AssetServiceProvider());

#7 : Doctrine DBAL & Idiorm
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'    => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'technews-lyon',
        'user'      => 'root',
        'password'  => ''
    ),
));

$app->register(new \Idiorm\Silex\Provider\IdiormServiceProvider(), array(
    'idiorm.db.options' => array(
        'connection_string' => 'mysql:host=localhost;dbname=technews-lyon',
        'username' => 'root',
        'password' => '',
        'id_column_overrides' => array(
            'article'       => 'IDARTICLE',
            'view_articles' => 'IDARTICLE'
        )
    )
));

#8.1 Récupération des Catégories
$app['technews_categories'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM categorie');
};

#8.2 Récupérations des Tags
$app['technews_tags'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM tags');
};

#8.3 Récupération des catégories avec Idiorm
$app['idiorm_categories'] = function() use ($app) {
    return $app['idiorm.db']->for_table('categorie')->find_result_set();  
};

#9 : Permet le rendu d'un controller dans la vue
# https://silex.symfony.com/doc/2.0/providers/twig.html#rendering-a-controller
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

#10 : Execution de l'Application
$app->run();


















