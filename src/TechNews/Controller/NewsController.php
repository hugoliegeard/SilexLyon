<?php
namespace TechNews\Controller;

use Silex\Application;

class NewsController
{
    /**
     * Affichage de la Page d'Accueil
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function indexAction(Application $app) {
        
        # Connexion à la BDD & Récupération des Articles
        $articles = $app['idiorm.db']->for_table('view_articles')
                                     ->find_result_set();
    
        # Récupération des Articles en Spotlight
        $spotlight = $app['idiorm.db']->for_table('view_articles')
                                      ->where('SPOTLIGHTARTICLE', 1)
                                      ->find_result_set();
    
        # Affichage dans le Vue
        return $app['twig']->render('index.html.twig', [
            'articles'  => $articles,
            'spotlight' => $spotlight
        ]);
    }
    
    /**
     * Affichage de la Page Catégorie
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function categorieAction($libellecategorie) {
        return "<h1>Catégorie : $libellecategorie</h1>";
    }
    
    /**
     * Affichage de la Page Article
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function articleAction($libellecategorie, $slugarticle, $idarticle) {
        # index.php/business/une-formation-innovante-a-lyon_986875674.html
        return "<h1>Article n° $idarticle | $slugarticle</h1>";
    }
    
}











