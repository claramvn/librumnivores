<?php

namespace App\Controller;

//use \App\Model\PostManager;

class FrontController 
{
    // Accueil
    public function home()
    {
        //$postManager = new PostManager();

        //$recentPost = $postManager->getRecentPost();

        /*if ($recentPost === false) {
            $_SESSION['error_recentPost'] = "Impossible d'afficher le dernier chapitre";
        }*/
        
        require('App/View/home.php');
    }

}
