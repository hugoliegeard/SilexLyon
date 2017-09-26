<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use TechNews\Provider\AuteurProvider;

$app->register(new SessionServiceProvider());

$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        # Création d'un Firewall (Main)
        'main'  => array(
            # Route d'application du firewall
            'pattern'   =>  '^/',
            # Autorisation de la méthode HTTP
            'http'      => true,
            # Autorisation des utilisateurs anonyme.
            'anonymous' => true,
            # Connexion via un Formulaire
            'form'  => array(
                'login_path'    => '/connexion',
                'check_path'    => '/admin/login_check'
            ),
            'logout' => array(
                'logout_path'   => '/deconnexion'  
            ),
            'users' =>  function() use($app) {
            return new AuteurProvider($app['idiorm.db']);
            }
        ) # Fin du firewall 'main'
        
    ), # Fin de 'security.firewalls'
    
    'security.access_rules' => array(
        # Seul les utilisateurs ayant un ROLE ADMIN, pourront
        # accéder aux routes commençant par /admin
        array('^/admin', 'ROLE_ADMIN', 'http'), 
        array('^/auteur', 'ROLE_AUTEUR', 'http')
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_AUTEUR')
    ) # Fin de 'security.role_hierarchy'
    
)); # Fin du 'SecurityServiceProvider'

$app['security.encoder.digest'] = function() use($app) {
    return new MessageDigestPasswordEncoder('sha1', false, 1);
};

$app['security.default_encoder'] = function() use($app) {
    return $app['security.encoder.digest'];
};


















