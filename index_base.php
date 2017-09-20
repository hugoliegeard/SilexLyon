<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * 1 : Importation de l'Autoload de Composer
 * Il permet de charger toutes les dépendances du projet
 * de façon automatique. Ex. Symfony, Pimple, Silex, ...
 */
require_once __DIR__.'/vendor/autoload.php';

/**
 * 2 : Instanciation de l'application Silex
 * @var \Silex\Application $app
 */
$app = new Application();

/**
 * 3 : Activation du Debuggage
 */
$app['debug'] = true;


/**
 * J'associe la route "/" à ma fonction anonyme
 * qui me renvoi le résultat à afficher.
 */
$app->get('/', function() {
   return '<h1>Page Accueil</h1>'; 
});

/**
 * Dans SILEX :
 * 1. Si ma route est détectée grâce à "match()"
 * 2. Alors, la fonction anonyme (closure - controller) est executée.
 * 3. Une réponse HTML et un code statut HTTP sont renvoyés au navigateur.
 * use Symfony\Component\HttpFoundation\Response;
 */
$app->match('/hello/{prenom}', function($prenom) {
   return new Response("<h1>Bonjour $prenom</h1>"); 
})->method('GET|POST')->value('prenom', 'Visiteur');

$app['prenom_visiteur'] = "Kristie";

/**
 * La fonction "protect" empêche l'execution de la fonction par PIMPLE
 * Je vais pouvoir l'executer moi-même avec " () "
 */
#$app['prenom_rand'] = $app->protect(function() {
#    return rand(1, 100);
#});

/**
 * La fonction "factory" ordonne à PIMPLE de créer une nouvelle
 * instance de ma classe / fonction.
 */
$app['prenom_rand'] = $app->factory(function() {
    return rand(1, 100);
});

$app->match('/hello2/{prenom}', function($prenom, Application $app) {
    return "Bonjour $prenom - ". $app['prenom_rand'];
})->method('GET|POST')->value('prenom', $app['prenom_rand']);

/**
 * Execution de Silex
 */
$app->run();

















