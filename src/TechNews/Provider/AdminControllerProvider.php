<?php
namespace TechNews\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class AdminControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        # : Récupérer l'instance de Silex\ControllerCollection
        # : https://silex.symfony.com/api/master/Silex/ControllerCollection.html
        $controllers = $app['controllers_factory'];
        
        # Connexion à l'Administration
        $controllers
            ->get('/connexion', 'TechNews\Controller\AdminController::connexionAction')
            ->bind('admin_connexion');
        
        # Inscription d'un Membre
        $controllers
            ->get('/inscription', 'TechNews\Controller\AdminController::inscriptionAction')
            ->bind('admin_inscription');
        
        # Ajouter un Article en BDD
        $controllers
            ->get('/article/ajouter', 'TechNews\Controller\AdminController::addarticleAction')
            ->bind('admin_add_article');
        
        return $controllers;
    }
}









