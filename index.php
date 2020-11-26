<?php
session_start();

// DISPLAY ERRORS
ini_set('error_reporting', E_ALL);

require_once('vendor/autoload.php');

use \App\Controller\FrontController;
use \App\Controller\UserController;
use \App\Controller\BookController;


try {
    if (isset($_GET['action'])) {
        $action = trim(htmlspecialchars($_GET['action']));
        switch ($action) {
            
            /*********************************************************************************
            ************************************ FrontController *****************************
            *********************************************************************************/

            case 'home':
                $frontController = new FrontController();
                $frontController->home();
            break;

            case 'mentions':
                $frontController = new FrontController();
                $frontController->mentions();
            break;

            case 'privacyPolicy':
                $frontController = new FrontController();
                $frontController->privacyPolicy();
            break;

            case 'error404':
                $frontController = new FrontController();
                $frontController->error404();
            break;
            

            /*********************************************************************************
            ************************************ UserController ******************************
            *********************************************************************************/

            case 'connection':
                $userController = new UserController();
                $userController->connection();
            break;

            case 'register':
                $userController = new UserController();
                $userController->register();
            break;

            case 'logout':
                $userController = new UserController;
                $userController->logout();
            break;

            case 'contact':
                $userController = new UserController();
                $userController->contact();
            break;

            case 'updateProfil':
                $userController = new UserController();
                $userController->updateProfil();
            break;

            case 'deleteUserAccount':
                $userController = new UserController();
                $userController->deleteUserAccount();
            break;

            /*********************************************************************************
            ************************************ BookController ******************************
            *********************************************************************************/

            case 'listBooks':
                $bookController = new BookController();
                $bookController->listBooks();
            break;

            case 'addBook':
                $bookController = new BookController();
                $bookController->addBook();
            break;

            case 'getBook':
                $bookController = new BookController();
                $bookController->getBook();
            break;

            case 'addToFavoritesBooks':
                $bookController = new BookController();
                $bookController->addToFavoritesBooks();
            break;

            case 'takeBackFromFavoritesBooks':
                $bookController = new BookController();
                $bookController->takeBackFromFavoritesBooks();
            break;

            case 'listFavoritesBooks':
                $bookController = new BookController();
                $bookController->listFavoritesBooks();
            break;

            case 'lendABook':
                $bookController = new BookController();
                $bookController->lendABook();
            break;

            case 'takeBackFromLentBooks':
                $bookController = new BookController();
                $bookController->takeBackFromLentBooks();
            break;

            case 'listLentBooks':
                $bookController = new BookController();
                $bookController->listLentBooks();
            break;

            case '$addWishBook':
                $bookController = new BookController();
                $bookController->$addWishBook();
            break;

            case 'listWishBooks':
                $bookController = new BookController();
                $bookController->listWishBooks();
            break;

            case 'addWishToBookcase':
                $bookController = new BookController();
                $bookController->addWishToBookcase();
            break;   
            
            case 'deleteBook':
                $bookController = new BookController();
                $bookController->deleteBook();
            break;
            
        }
    } else {
        $frontController = new FrontController();
        $frontController->home();
    }
} catch (Exception $e) {
    $frontController = new FrontController();
    $frontController->error404();
}
