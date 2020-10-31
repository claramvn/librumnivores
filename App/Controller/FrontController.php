<?php

namespace App\Controller;

//use \App\Model\PostManager;

class FrontController 
{
    // Accueil
    public function home()
    {
        require('App/View/home.php');
    }

    // Mentions légales
    public function mentions()
    {
        require('App/View/mentions.php');
    }

    // Politique de confidentialité
    public function privacyPolicy()
    {
        require('App/View/policy.php');
    }

}
