<?php
//session_start();
// Affichage des erreurs
ini_set('error_reporting', E_ALL);

require_once('vendor/autoload.php');

use \App\Controller\FrontController;
use \App\Controller\UserController;
//use \App\Controller\PostController;
//use \App\Controller\CommentController;


try {
    if (isset($_GET['action'])) {
        $action = trim(htmlspecialchars($_GET['action']));
        switch ($action) {
            
            /*********************************************************************************
            ************************************ FrontController *****************************
            *********************************************************************************/

            // Accueil
            case 'home':
                $frontController = new FrontController();
                $frontController->home();
            break;

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


            /*********************************************************************************
            ************************************ UserController ******************************
            *********************************************************************************/

            // Connexion
            case 'connection':
                $userController = new UserController();
                $userController->connection();
            break;

            // Inscription
            case 'registration':
                $userController = new UserController();
                $userController->registration();
            break;

            // Contact
            case 'contact':
                $userController = new UserController();
                $userController->contact();
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
