<?php

#1 : Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'    => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'technews-lyon',
        'user'      => 'root',
        'password'  => ''
    ),
));

#2 : Idiorm ORM
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

#3 Récupération des Catégories
$app['technews_categories'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM categorie');
};

#4.1 Récupérations des Tags
$app['technews_tags'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM tags');
};

#4.2 Récupération des catégories avec Idiorm
$app['idiorm_categories'] = function() use ($app) {
    return $app['idiorm.db']->for_table('categorie')->find_result_set();
};

#4.3 : Permet le rendu d'un controller dans la vue
# https://silex.symfony.com/doc/2.0/providers/twig.html#rendering-a-controller
$app->register(new Silex\Provider\HttpFragmentServiceProvider());
