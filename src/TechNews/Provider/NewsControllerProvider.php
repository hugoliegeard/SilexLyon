<?php
namespace TechNews\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class NewsControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritDoc}
     * @see \Silex\Api\ControllerProviderInterface::connect()
     */
    public function connect(Application $app)
    {
        # : Récupérer l'instance de Silex\ControllerCollection
        # : https://silex.symfony.com/api/master/Silex/ControllerCollection.html
        $controllers = $app['controllers_factory'];
        
            #Page d'Accueil
            $controllers
                # On associe une Route à un Controller et une Action
                ->get('/','TechNews\Controller\NewsController::indexAction')
                # En option, je peux donner un nom à la route, qui servira
                # plus tard pour la création de liens.
                ->bind('news_index');
            
            #Page Catégorie
            $controllers
                ->get('/categorie/{libellecategorie}',
                        'TechNews\Controller\NewsController::categorieAction')
                # Je spécifie le type de paramètre attendu avec une Regex
                ->assert('libellecategorie', '[^/]+')
                # Je peux attribuer une valeur par défaut.
                ->value('libellecategorie', 'computing')
                # Nom de ma Route
                ->bind('news_categorie');
            
            # Page Article
            $controllers
                ->get('/{libellecategorie}/{slugarticle}_{idarticle}.html',
                        'TechNews\Controller\NewsController::articleAction')
                ->assert('idarticle', '\d+')
                ->bind('news_article');
            
            #PHP Info
            $controllers
                ->get('/infos',
                    [ $this, 'infoAction' ]);
            
            # Connexion à l'Administration
            $controllers
            ->get('/connexion', 'TechNews\Controller\NewsController::connexionAction')
            ->bind('news_connexion');
            
            # Inscription d'un Membre
            $controllers
            ->get('/inscription', 'TechNews\Controller\NewsController::inscriptionAction')
            ->bind('news_inscription');
        
        # On retourne la liste des controllers (ControllerCollection)
        return $controllers;
            
    }
    
    public function infoAction() {
        return phpinfo();
    }
}












