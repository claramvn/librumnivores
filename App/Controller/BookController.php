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

        $filter = $this->cleanParam($_GET['f']);

        $title = $this->cleanParam($_POST['title_book']);
        $author = $this->cleanParam($_POST['author_book']);
        $isbn10 = $this->cleanParam($_POST['isbn10_book']);
        $isbn13 = $this->cleanParam($_POST['isbn13_book']);
        $publisher = $this->cleanParam($_POST['publisher_book']);
        $pageCount = $this->cleanParam($_POST['page_count_book']);
        $publishedDate = $this->cleanParam($_POST['published_date_book']);
        $shortDescription = $this->cleanParam($_POST['short_description_book']);
        $description = $this->cleanParam($_POST['description_book']);
        $cover = $this->cleanParam($_POST['image_book']);
    
        // ADD directly to bookcase
        if (isset($_POST['button_add'])) {

            if(empty($title) || empty($author) || empty($isbn10) || empty($isbn13) || empty($publisher) || empty($publishedDate) || empty($pageCount) || empty($shortDescription) || empty($description) || empty($cover)) {
                $_SESSION['error_add_book'] = "Oups, un problème est survenu. Impossible d'ajouter le livre à votre bibliothèque.";
            }

            $bookByIsbn = $this->bookManager->getBookByIsbn($idUser, $isbn10, $isbn13);
            if(isset($bookByIsbn['isbn10_book']) && isset($bookByIsbn['isbn13_book']) && $bookByIsbn['isbn10_book'] === $isbn10 && $bookByIsbn['isbn13_book'] === $isbn13) {
                $_SESSION['error_add_book'] = "Oups, ce livre appartient déjà à votre bibliothèque !";
            }


            if(!isset($_SESSION['error_add_book'])) {

                $addBook = $this->bookManager->addBook($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser);

                if($addBook === false) {
                    $_SESSION['error_add_book'] = "Oups désolé, impossible d'ajouter le livre à votre bibliothèque.";
                    header('Location:index.php?action=listBooks&f=' . $filter);
                } 

                $_SESSION['success_add_book'] = "Le livre a bien été ajouté à votre bibliothèque.";
                header('Location:index.php?action=listBooks&f=' . $filter);

            } else {
                header('Location:index.php?action=listBooks&f=' . $filter);
            }
        }

        // ADD to wish list
        if (isset($_POST['button_add_wish'])) {

            if(empty($title) || empty($author) || empty($isbn10) || empty($isbn13) || empty($publisher) || empty($publishedDate) || empty($pageCount) || empty($shortDescription) || empty($description) || empty($cover)) {
                $_SESSION['error_add_book'] = "Oups, un problème est survenu. Impossible d'ajouter le livre à votre bibliothèque des souhaits.";
            }

            $bookByIsbn = $this->bookManager->getBookByIsbn($isbn10, $isbn13, $idUser);
            if(isset($bookByIsbn['isbn10_book']) && isset($bookByIsbn['isbn13_book']) && $bookByIsbn['isbn10_book'] === $isbn10 && $bookByIsbn['isbn13_book'] === $isbn13) {
                $_SESSION['error_add_book'] = "Oups, ce livre appartient déjà à votre bibliothèque !";
            }

            if(!isset($_SESSION['error_add_book'])) {

                $addWishBook = $this->bookManager->addWishBook($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser);

                if($addWishBook === false) {
                    $_SESSION['error_add_book'] = "Oups désolé, impossible d'ajouter le livre à votre bibliothèque des souhaits.";
                    header('Location:index.php?action=listBooks&f=' . $filter);
                } 
                
                $_SESSION['success_add_wish_book'] = "Le livre a bien été ajouté à votre bibliothèque des souhaits.";
                header('Location:index.php?action=listWishBooks&f=' . $filter);
                

            } else {
                header('Location:index.php?action=listBooks&f=' . $filter);
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

        $perPage = 12;

        $pages = ceil($bookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        if (isset($_GET['f']) AND !empty($_GET['f'])) {
            $filter = $this->cleanParam($_GET['f']);
            if($filter === "title") {
                $sortKey = "title_book";
            } else if ($filter === "author") {
                $sortKey = "author_book";
            } else if ($filter === "all") {
                $sortKey = "date_add_book";
            } else {
                $sortKey = "date_add_book";
            }
        }
        else {
            $sortKey = "date_add_book";
        }

        if(isset($_POST['button_search_engine'])) {
            if(isset($_POST['content_search']) && !empty($_POST['content_search'])) {
                $wishBook = 0;
                $lendBook = 0;
                $content = $this->cleanParam($_POST['content_search']);

                $searchBooks = $this->bookManager->listSearchBooks($idUser, $wishBook, $lendBook, $content);
                $countedBooksSearch = count($searchBooks);
            } 
        } 

        $books = $this->bookManager->listBooks($idUser, $sortKey, $first, $perPage);

        $listLentBooks = $this->bookManager->listLentBooks($idUser, $sortKey, $first, $perPage);

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

        $perPage = 12;

        $pages = ceil($wishBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        if (isset($_GET['f']) AND !empty($_GET['f'])) {
            $filter = $this->cleanParam($_GET['f']);
            if($filter === "title") {
                $sortKey = "title_book";
            } else if ($filter === "author") {
                $sortKey = "author_book";
            } else if ($filter === "all") {
                $sortKey = "date_add_book";
            } else {
                $sortKey = "date_add_book";
            }
        }
        else {
            $sortKey = "date_add_book";
        }

        if(isset($_POST['button_search_engine'])) {
            if(isset($_POST['content_search']) && !empty($_POST['content_search'])) {
                $wishBook = 1;
                $lendBook = 0;
                $content = $this->cleanParam($_POST['content_search']);

                $searchBooks = $this->bookManager->listSearchBooks($idUser, $wishBook, $lendBook, $content);
                $countedBooksSearch = count($searchBooks);
            } 
        } 

        $listWishBooks = $this->bookManager->listWishBooks($idUser, $sortKey, $first, $perPage);

        if ($listWishBooks === false) {
            header('Location: index.php?action=error404');
        }

        require('App/View/listWishBooks.php');
    }

    // LIST FAVORITES BOOKCASE
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

        $perPage = 12;

        $pages = ceil($favoritesBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        if (isset($_GET['f']) AND !empty($_GET['f'])) {
            $filter = $this->cleanParam($_GET['f']);
            if($filter === "title") {
                $sortKey = "title_book";
            } else if ($filter === "author") {
                $sortKey = "author_book";
            } else if ($filter === "all") {
                $sortKey = "date_add_book";
            } else {
                $sortKey = "date_add_book";
            }
        }
        else {
            $sortKey = "date_add_book";
        }

        if(isset($_POST['button_search_engine'])) {
            if(isset($_POST['content_search']) && !empty($_POST['content_search'])) {
                $content = $this->cleanParam($_POST['content_search']);

                $searchFavBooks = $this->bookManager->listSearchFavBooks($idUser, $content);
                $countedFavBooksSearch = count($searchFavBooks);
            } 
        } 

        $favoritesBooks = $this->bookManager->listFavoritesBooks($idUser, $sortKey, $first, $perPage);

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

        $perPage = 12;

        $pages = ceil($lentBookCount / $perPage);

        $first = ($currentPage * $perPage) - $perPage;

        if (isset($_GET['f']) AND !empty($_GET['f'])) {
            $filter = $this->cleanParam($_GET['f']);
            if($filter === "title") {
                $sortKey = "title_book";
            } else if ($filter === "author") {
                $sortKey = "author_book";
            } else if ($filter === "all") {
                $sortKey = "date_add_book";
            } else {
                $sortKey = "date_add_book";
            }
        }
        else {
            $sortKey = "date_add_book";
        }

        if(isset($_POST['button_search_engine'])) {
            if(isset($_POST['content_search']) && !empty($_POST['content_search'])) {
                $wishBook = 0;
                $lendBook = 1;
                $content = $this->cleanParam($_POST['content_search']);

                $searchBooks = $this->bookManager->listSearchBooks($idUser, $wishBook, $lendBook, $content);
                $countedBooksSearch = count($searchBooks);
            } 
        } 

        $listLentBooks = $this->bookManager->listLentBooks($idUser, $sortKey, $first, $perPage);

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

        $titleBook = $book['title_book'];
        $authorBook = $book['author_book'];
        $coverBook = $book['cover_book'];
        $descriptionBook = $book['description_book'];
 
        if ($book === false || !isset($idBook) || $idBook === 0) {
            header('Location: index.php?action=error404');
        }

        require('App/View/getBook.php');
    }

    // STRUCTURE METHOD FOR ADD/REMOVE WISH/FAVORITES/LENT BOOKS
    public function structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage) {

        if (!$this->isLogged()) {
            header('Location: index.php');
        }
        
        $idBook = intval($this->cleanParam($_GET['id']));
        
        $idUser = $this->user['id_user'];
        
        $filter = $this->cleanParam($_GET['f']);

        $newObject = $this->bookManager->$objectModel($idBook,$idUser);
        
        if ($newObject === false || !isset($idBook) || $idBook === 0 ) {
            $_SESSION['error_flags'] = $errorMessage;
            header('Location: index.php?action=getBook&id=' . $idBook . '&f=' . $filter . '#flags');
        } else {
            $_SESSION['success_flags'] = $successMessage;
            header('Location: index.php?action=getBook&id=' . $idBook . '&f=' . $filter . '#flags');
        }
    }

    // ADD WISH BOOK TO BOOKCASE
    public function addWishToBookcase()
    {
        $objectModel = "addWishToBookcase";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre à votre bibliothèque.";
        $successMessage = "Le livre a bien été ajouté à votre bibliothèque.";

        $this->structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage);
    }

    // ADD BOOK TO FAVORITES BOOKS BOOKCASE
    public function addToFavoritesBooks()
    {
        $objectModel = "addToFavoritesBooks";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre à vos favoris.";
        $successMessage = "Le livre a bien été ajouté à vos favoris.";

        $this->structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage);
    }

    // TAKE BACK FROM FAVORITES BOOKS BOOKCASE
    public function takeBackFromFavoritesBooks()
    {
        $objectModel = "takeBackFromFavoritesBooks";
        $errorMessage = "Oups, désolé mais il est impossible de retirer le livre de vos favoris.";
        $successMessage = "Le livre a bien été retiré de vos favoris.";

        $this->structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage);
    }

    // ADD TO LENT BOOK BOOKCASE
    public function lendABook()
    {
        $objectModel = "lendABook";
        $errorMessage = "Oups, désolé mais il est impossible d'ajouter le livre aux prêts.";
        $successMessage = "Le livre a bien été ajouté à vos prêts.";

        $this->structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage);
    }

    // TAKE BACK FROM LENT BOOK BOOKCASE
    public function takeBackFromLentBooks()
    {
        $objectModel = "takeBackFromLentBooks";
        $errorMessage = "Oups, désolé mais il est impossible de retirer le livre de vos prêts.";
        $successMessage = "Le livre a bien été retiré de vos prêts.";

        $this->structureMethodAddOrRemoveFlags($objectModel, $errorMessage, $successMessage);
    }

    // UPDATE INFOS BOOK
    public function updateInfosBook()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idUser = $this->user['id_user'];

        $filter = $this->cleanParam($_GET['f']);
    
        if (isset($_POST['button_updates_book'])) {
            $idBook = $this->cleanParam($_POST['id_book']);;

            $book = $this->bookManager->getBook($idBook, $idUser);

            $titleBook = $this->cleanParam($_POST['title_book']);
            $authorBook = $this->cleanParam($_POST['author_book']);
            $descriptionBook = $this->cleanParam($_POST['description_book']);
                
            if (empty($titleBook) || empty($authorBook) || empty($descriptionBook)) {
                $titleBook = $this->cleanParam($book['title_book']);
                $authorBook = $this->cleanParam($book['author_book']);
                $descriptionBook = $this->cleanParam($book['description_book']);
                $_SESSION['errors_updates']['empty_fields_book'] = "Tous les champs sont nécessaires.";
            } else {
                $titleBook = $this->cleanParam($_POST['title_book']);
                $authorBook = $this->cleanParam($_POST['author_book']);
                $descriptionBook = $this->cleanParam($_POST['description_book']);
            }
 
            if ($_POST['title_book'] !== $book['title_book']) {
                $titleBook = $this->cleanParam($_POST['title_book']);
                $_SESSION['success_updates']['title_book'] = "Le titre a bien été modifié.";
            } else {
                $titleBook = $this->cleanParam($book['title_book']);
            }

            if ($_POST['author_book'] !== $book['author_book']) {
                $authorBook = $this->cleanParam($_POST['author_book']);
                $_SESSION['success_updates']['author_book'] = "L'auteur a bien été modifié.";
            } else {
                $authorBook = $this->cleanParam($book['author_book']);
            }
        
            if ($_POST['description_book'] !== $book['description_book']) {
                $descriptionBook = $this->cleanParam($_POST['description_book']);
                $_SESSION['success_updates']['description_book'] = "La description a bien été modifiée.";
            } else {
               $descriptionBook = $this->cleanParam($book['description_book']);
            }

            if (isset($_FILES["cover_book"]) && $_FILES["cover_book"]["error"] == 0) {
                $file = $_FILES['cover_book'];
                $extensionUpload = $this->checkExtensionFileUpload($file);
                $extensionAllowed = $this->checkIfExtensionIsAllowed();

                if (!$this->checkMaxSize($file)) {
                    $_SESSION['errors_updates']['size_cover_book'] = "Impossible de modifier l'image : le fichier est trop volumineux";
                }

                if (!in_array($extensionUpload, $extensionAllowed)) {
                    $_SESSION['errors_updates']['ext_cover_book'] = "Impossible de modifier l'image : le fichier n'est pas au format jpg/jpeg/png/gif";
                } 

                if (!isset($_SESSION['errors_updates']['size_cover_book']) && !isset($_SESSION['errors_updates']['ext_cover_book'])) {

                    if(isset($book['cover_book']) && !preg_match("(http)", $book['cover_book']) && !preg_match("(noimg)", $book['cover_book'])) {
                        unlink('Public/img/cover/' . $book['cover_book']);
                    }
                    $nameFile = $this->renameFile($file, $extensionUpload);
                    $uploadCover = $this->uploadCoverFile($file, $nameFile);

                    $coverBook = $nameFile;

                    $_SESSION['success_updates']['cover_book'] = "L'image a bien été modifiée";
                } else {
                    $coverBook = $book['cover_book'];
                }

            } else {
                $coverBook = $book['cover_book'];
            }

            $updateInfosBook = $this->bookManager->updateInfosBook($titleBook, $authorBook, $coverBook, $descriptionBook, $idBook, $idUser);
            header('Location: index.php?action=getBook&id=' . $idBook . '&f=' . $filter);
        }
    }

    // DELETE SELECTED BOOK
    public function deleteBook()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $idBook = intval($this->cleanParam($_GET['id']));

        $idUser = $this->user['id_user'];

        $filter = $this->cleanParam($_GET['f']);

        $book = $this->bookManager->getBook($idBook, $idUser);

        if(isset($book['cover_book']) && !preg_match("(http)", $book['cover_book']) && !preg_match("(noimg)", $book['cover_book'])) {
            unlink('Public/img/cover/' . $book['cover_book']);
        }

        $deleteBook = $this->bookManager->deleteBook($idBook, $idUser);

        if ($deleteBook === false || !isset($idBook) || $idBook === 0) {
            $_SESSION['error_flags'] = "Oups, désolé mais il est impossible de supprimmer le livre séléctionné.";
            header('Location: index.php?action=getBook&id=' . $idBook . '&f=' . $filter . '#flags');
        } else {
            header('Location: index.php?action=listBooks&f=' . $filter);
        }
    }

}
