<?php
namespace TechNews\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
    public function categorieAction($libellecategorie, Application $app) {
        
        # Connexion à la BDD et la Récupération des Articles de la Catégorie
        $articles = $app['idiorm.db']->for_table('view_articles')
                                     ->where('LIBELLECATEGORIE', ucfirst($libellecategorie)) 
                                     ->find_result_set();
        
        # Transmission à la vue      
        return $app['twig']->render('categorie.html.twig', [
            'articles'          => $articles,
            'libellecategorie'  => $libellecategorie
        ]);
    }
    
    /**
     * Affichage de la Page Article
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function articleAction(
        $libellecategorie, 
        $slugarticle, 
        $idarticle,
        Application $app) {
        
        # index.php/business/une-formation-innovante-a-lyon_986875674.html
        # Récupération de l'Article
        $article = $app['idiorm.db']->for_table('view_articles')
                                    ->find_one($idarticle);
        
        # Récupérer des Articles de la Catégories (suggestions)
        $suggestions = $app['idiorm.db']->for_table('view_articles')
        
        # Je récupère uniquement les articles de la même catégorie que mon article
        ->where('LIBELLECATEGORIE', ucfirst($libellecategorie))
        
        # Sauf mon article en cours
        ->where_not_equal('IDARTICLE', $idarticle)
        
        # 3 articles maximum
        ->limit(3)
        
        # Par ordre décroissant
        ->order_by_desc('IDARTICLE')
        
        # Je récupère les résultats
        ->find_result_set();
        
        # Transmission à la Vue
        return $app['twig']->render('article.html.twig', [
           'article'     => $article,
           'suggestions' => $suggestions
        ]);
    }
    
    /**
     * Génération du Menu dans le Layout
     * @param Application $app
     */
    public function menu($active, Application $app) {
        
        # -- Récupération des Catégories
        $categories = $app['idiorm.db']->for_table('categorie')->find_result_set();
        
        # -- Transmission à la Vue
        return $app['twig']->render('menu.html.twig', [
            'categories' => $categories,
            'active'     => $active
        ]);
        
    }
    
    /**
     * Génération de la Sidebar dans le Layout
     * @param Application $app
     */
    public function sidebar(Application $app) {
        
        # Récupération des informations pour la sidebar
        $sidebar = $app['idiorm.db']->for_table('view_articles')
                                    ->order_by_desc('DATECREATIONARTICLE')
                                    ->limit(5)
                                    ->find_result_set();
        
        $special = $app['idiorm.db']->for_table('view_articles')
                                    ->where('SPECIALARTICLE', 1)
                                    ->find_result_set();                                   
                                    
        # Transmission à la Vue
        return $app['twig']->render('sidebar.html.twig', [
           'sidebar'    => $sidebar,
           'special'    => $special
        ]);
    }
    
    /**
     * Affichage de la Page Connexion
     * @use Symfony\Component\HttpFoundation\Request;
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function connexionAction(Application $app, Request $request) {
        return $app['twig']->render('connexion.html.twig',[
            'error'         =>  $app['security.last_error']($request),
            'last_username' =>  $app['session']->get('_security.last_username')
        ]);
    }
    
    /**
     * Affichage de la Page Connexion
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function inscriptionAction(Application $app) {
        return $app['twig']->render('inscription.html.twig');
    }
    
    /**
     * Traitement POST du Formulaire d'Inscription
     * @param Application $app
     * @param Request $request
     */
    public function inscriptionPost(Application $app, Request $request) {
        
        # Vérification et la Sécurisation des données POST
        # Sanitize...
        # ...
        
        # Connexion à la BDD
        $auteur = $app['idiorm.db']->for_table('auteur')->create();
        
        # Affectation des valeurs
        $auteur->PRENOMAUTEUR   = $request->get('PRENOMAUTEUR');
        $auteur->NOMAUTEUR      = $request->get('NOMAUTEUR');
        $auteur->EMAILAUTEUR    = $request->get('EMAILAUTEUR');
        $auteur->MDPAUTEUR      = $app['security.encoder.digest']
                        ->encodePassword($request->get('MDPAUTEUR'), '');         
        $auteur->ROLESAUTEUR    = $request->get('ROLESAUTEUR');
        
        # On persiste en BDD
        $auteur->save();
        
        # On envoi un email de confirmation ou de bienvenue...
        # On envoi une notification à l'administrateur...
        # ...
        
        # On redirige l'utilisateur sur la page de connexion
        return $app->redirect('connexion?inscription=success');
        
    }
    
}


















