<?php
namespace TechNews\Controller;

class NewsController
{
    /**
     * Affichage de la Page d'Accueil
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function indexAction() {
        return '<h1>Accueil</h1>';
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











