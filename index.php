<?php
//session_start();
// Affichage des erreurs
ini_set('error_reporting', E_ALL);

require_once('vendor/autoload.php');

use \App\Controller\FrontController;
//use \App\Controller\PostController;
//use \App\Controller\CommentController;
//use \App\Controller\UserController;

try {
    if (isset($_GET['action'])) {
        $action = trim(htmlspecialchars($_GET['action']));
        switch ($action) {
            
            /*********************************************************************************
            ************************************ FrontController *****************************
            *********************************************************************************/

            // Mentions légales
            case 'mentions':
                $frontController = new FrontController();
                $frontController->mentions();
            break;

            // Politique de confidentialité
            case 'privacyPolicy':
                $frontController = new FrontController();
                $frontController->privacyPolicy();
            break;

            
        }
    } else {
        //Accueil
        $frontController = new FrontController();
        $frontController->home();
    }
} catch (Exception $e) {
    //page erreur
    $frontController = new FrontController();
    $frontController->home();
}
