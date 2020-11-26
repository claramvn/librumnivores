<?php

namespace App\Controller;

use \App\Model\BookManager;

class BookController extends AncestorController
{    
    function __construct()
	{
		$this->bookManager = new BookManager();
	}

    // ADD TO BOOKCASE
    public function addBook()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        $title = $this->cleanParam($_POST['title_book']);
        $author = $this->cleanParam($_POST['author_book']);
        $isbn = $this->cleanParam($_POST['isbn_book']);
        $publisher = $this->cleanParam($_POST['publisher_book']);
        $pageCount = $this->cleanParam($_POST['page_count_book']);
        $publishedDate = $this->cleanParam($_POST['published_date_book']);
        $shortDescription = $this->cleanParam($_POST['short_description_book']);
        $description = $this->cleanParam($_POST['description_book']);
        $cover = $this->cleanParam($_POST['image_book']);
    
        // ADD directly to bookcase
        if (isset($_POST['button_add'])) {

            if(empty($title) || empty($author) || empty($isbn) || empty($publisher) || empty($publishedDate) || empty($pageCount) || empty($shortDescription) || empty($description) || empty($cover)) {
                $_SESSION['error_add_book'] = "Le livre séléctionné fait déjà parti de votre bibliothèque.";
            }

            
            $bookExist = $this->bookManager->bookExist($isbn, $idUser);
            if ($bookExist['isbn_book'] === $isbn) {
                $_SESSION['error_add_book'] = "Le livre séléctionné fait déjà parti de votre bibliothèque.";
            }

            if(!$_SESSION['error_add_book']) {

                $addBook = $this->bookManager->addBook($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser);

                if($addBook !== false) {
                    $_SESSION['success_add_book'] = "Le livre a bien été ajouté à votre bibliothèque.";
                    header('Location:index.php?action=listBooks');
                }

            } else {
                header('Location:index.php?action=listBooks');
            }
        }

        // ADD to wish list
        if (isset($_POST['button_add_wish'])) {

            if(empty($title) || empty($author) || empty($isbn) || empty($publisher) || empty($publishedDate) || empty($pageCount) || empty($shortDescription) || empty($description) || empty($cover)) {
                $_SESSION['error_add_book'] = "Oups, un problème est survenu. Impossible d'ajouter le livre à votre bibliothèque des souhaits.";
            }

            $bookExist = $this->bookManager->bookExist($isbn, $idUser);
            if ($bookExist['isbn_book'] === $isbn) {
                $_SESSION['error_add_book'] = "Le livre séléctionné fait déjà parti de votre bibliothèque.";
            }

            if(!$_SESSION['error_add_book']) {

                $addWishBook = $this->bookManager->addWishBook($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser);

                if($addWishBook !== false) {
                    $_SESSION['success_add_wish_book'] = "Le livre a bien été ajouté à votre bibliothèque des souhaits.";
                    header('Location:index.php?action=listWishBooks');
                } 

            } else {
                header('Location:index.php?action=listBooks');
            }

        }

    } 

    // LIST BOOKCASE
    public function listBooks()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        if (isset($_GET['page']) AND !empty($_GET['page'])) {
            $currentPage = (int) $this->cleanParam($_GET['page']);
        }
        else {
            $currentPage = 1;
        }

        $bookCount = $this->bookManager->bookCount($idUser);

        $perPage = 6;

        $pages = ceil($bookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        $books = $this->bookManager->listBooks($idUser, $first, $perPage);

        $listLentBooks = $this->bookManager->listLentBooks($idUser, $first, $perPage);

        $countedLentBooks = count($listLentBooks);

        if ($books === false && $listLentBooks === false) {
            header('Location: index.php?action=error404');
        }

        require('App/View/listBooks.php');
    }

    // LIST WISH BOOKCASE
    public function listWishBooks()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        if (isset($_GET['page']) AND !empty($_GET['page'])) {
            $currentPage = (int) $this->cleanParam($_GET['page']);
        }
        else {
            $currentPage = 1;
        }

        $wishBookCount = $this->bookManager->wishBookCount($idUser);

        $perPage = 6;

        $pages = ceil($wishBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        $listWishBooks = $this->bookManager->listWishBooks($idUser, $first, $perPage);

        if ($listWishBooks === false) {
            header('Location: index.php?action=error404');
        }

        require('App/View/listWishBooks.php');
    }

    // LIST FAVORITES BOOKS BOOKCASE
    public function listFavoritesBooks()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        if (isset($_GET['page']) AND !empty($_GET['page'])) {
            $currentPage = (int) $this->cleanParam($_GET['page']);
        }
        else {
            $currentPage = 1;
        }

        $favoritesBookCount = $this->bookManager->favoritesBookCount($idUser);

        $perPage = 6;

        $pages = ceil($favoritesBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        $favoritesBooks = $this->bookManager->listFavoritesBooks($idUser, $first, $perPage);

        if ($favoritesBooks === false) {
            header('Location: index.php?action=error404');
        }

        require('App/View/listFavoritesBooks.php');
    }

    // LIST LENT BOOKS BOOKCASE
    public function listLentBooks()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        if (isset($_GET['page']) AND !empty($_GET['page'])) {
            $currentPage = (int) $this->cleanParam($_GET['page']);
        }
        else {
            $currentPage = 1;
        }

        $lentBookCount = $this->bookManager->lentBookCount($idUser);

        $perPage = 6;

        $pages = ceil($lentBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        $listLentBooks = $this->bookManager->listLentBooks($idUser, $first, $perPage);

        if ($listLentBooks === false) {
            header('Location: index.php?action=error404');
        }

        require('App/View/listLentBooks.php');
    }

    // GET SELECTED BOOK
    public function getBook()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idBook = intval($this->cleanParam($_GET['id']));

        $idUser = $this->user['id_user'];

        $book = $this->bookManager->getBook($idBook, $idUser);
 
        if ($book === false || !isset($idBook) || $idBook === 0) {
            header('Location: index.php?action=error404');
        }

        require('App/View/getBook.php');
    }

    // SKELETON METHOD FOR ADD/REMOVE WISH/FAVORITES/LENT BOOKS
    public function structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage) {

        if (!$this->isLogged()) {
            header('Location: index.php');
        }
        
        $idBook = intval($this->cleanParam($_GET['id']));
        
        $idUser = $this->user['id_user'];
        
        $newObject = $this->bookManager->$objectModel($idBook,$idUser);
        
        if ($newObject === false || !isset($idBook) || $idBook === 0 ) {
            $_SESSION['error_flags'] = $errorMessage;
            header('Location: index.php?action=getBook&id=' . $idBook . '#flags');
        } else {
            $_SESSION['success_flags'] = $successMessage;
            header('Location: index.php?action=getBook&id=' . $idBook . '#flags');
        }
    }

    // ADD WISH BOOK TO BOOKCASE
    public function addWishToBookcase()
    {
        $newObject = "$" . "addWishToBookcase";
        $objectModel = "addWishToBookcase";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre à votre bibliothèque.";
        $successMessage = "Le livre a bien été ajouté à votre bibliothèque.";

        $this->structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage);
    }

    // ADD BOOK TO FAVORITES BOOKS BOOKCASE
    public function addToFavoritesBooks()
    {
        $newObject = "$" . "addToFavoritesBooks";
        $objectModel = "addToFavoritesBooks";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre à vos favoris.";
        $successMessage = "Le livre a bien été ajouté à vos favoris.";

        $this->structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage);
    }

    // TAKE BACK FROM FAVORITES BOOKS BOOKCASE
    public function takeBackFromFavoritesBooks()
    {
        $newObject = "$" . "takeBackFromFavoritesBooks";
        $objectModel = "takeBackFromFavoritesBooks";
        $errorMessage = "Oups, désolé mais il est impossible de retirer le livre de vos favoris.";
        $successMessage = "Le livre a bien été retiré de vos favoris.";

        $this->structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage);
    }

    // ADD TO LENT BOOK BOOKCASE
    public function lendABook()
    {
        $newObject = "$" . "lendABook";
        $objectModel = "lendABook";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre aux prêts.";
        $successMessage = "Le livre a bien été ajouté à vos prêts.";

        $this->structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage);
    }

    // TAKE BACK FROM LENT BOOK BOOKCASE
    public function takeBackFromLentBooks()
    {
        $newObject = "$" . "takeBackFromLentBooks";
        $objectModel = "takeBackFromLentBooks";
        $errorMessage = "Oups, désolé mais il est impossible de retirer le livre de vos prêts.";
        $successMessage = "Le livre a bien été retiré de vos prêts.";

        $this->structureMethodAddOrRemoveFlags($newObject, $objectModel, $errorMessage, $successMessage);
    }

    // DELETE SELECTED BOOK
    public function deleteBook()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idBook = intval($this->cleanParam($_GET['id']));

        $idUser = $this->user['id_user'];

        $deleteBook = $this->bookManager->deleteBook($idBook, $idUser);

        if ($deleteBook === false || !isset($idBook) || $idBook === 0) {
            $_SESSION['error_flags'] = "Oups, désolé mais il est impossible de supprimmer le livre séléctionné.";
            header('Location: index.php?action=getBook&id=' . $idBook . '#flags');
        } else {
            $_SESSION['success_delete_book'] = "Le livre a bien été supprimé de votre bibliothèque.";
            header('Location: index.php?action=listBooks');
        }
    }

}
