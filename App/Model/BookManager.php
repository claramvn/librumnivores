<?php

namespace App\Model;

class BookManager extends Manager
{
    // ADD BOOK
    public function addBook($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO books (isbn10_book, isbn13_book, title_book, author_book, cover_book, publisher_book, published_date_book, page_count_book, short_description_book, description_book, wish_book, favorite_book, lend_book, date_add_book, id_user ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, NOW(), ?)');
        $addBook = $req->execute(array($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser));
        return $addBook;
    }

    // GET BOOK BY ISBN
    public function getBookByIsbn($idUser, $isbn10, $isbn13)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT isbn10_book, isbn13_book, id_user FROM books WHERE id_user = ? AND ( isbn10_book = ? OR isbn13_book = ? )');
        $req->execute(array($idUser, $isbn10, $isbn13));
        $book = $req->fetch();
        $req->closeCursor();
        return $book;
    }

    // COUNT BOOKS OF BOOKCASE
    public function bookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND wish_book = 0 AND lend_book = 0');
        $req->execute(array($idUser));
        $bookCount = $req->fetch();
        return $bookCount['total'];
    }

    // LIST BOOKS OF BOOKCASE
    public function listBooks($idUser, $sortKey, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, author_book, cover_book, wish_book, lend_book, date_add_book, id_user FROM books WHERE wish_book = 0 AND lend_book = 0 AND id_user = ? ORDER BY $sortKey LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $books = $req->fetchAll();
        $req->closeCursor();
        return $books;
    }

    // LIST SEARCH BOOKS
    public function listSearchBooks($idUser, $wishBook, $lendBook, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, isbn10_book, isbn13_book, title_book, author_book, cover_book, wish_book, favorite_book, lend_book, date_add_book, id_user FROM books WHERE (isbn10_book LIKE '%$content%' OR isbn13_book LIKE '%$content%' OR title_book LIKE '%$content%' OR author_book LIKE '%$content%') AND id_user = ? AND wish_book = ? AND lend_book = ? LIMIT 24");
        $req->execute(array($idUser, $wishBook, $lendBook));
        $searchBooks = $req->fetchAll();
        $req->closeCursor();
        return $searchBooks;
    }

    // LIST SEARCH BOOKS
    public function listSearchFavBooks($idUser, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, isbn10_book, isbn13_book, title_book, author_book, cover_book, wish_book, favorite_book, lend_book, date_add_book, id_user FROM books WHERE (isbn10_book LIKE '%$content%' OR isbn13_book LIKE '%$content%' OR title_book LIKE '%$content%' OR author_book LIKE '%$content%') AND id_user = ? AND wish_book = 0 AND favorite_book = 1 LIMIT 24");
        $req->execute(array($idUser));
        $searchFavBooks = $req->fetchAll();
        $req->closeCursor();
        return $searchFavBooks;
    }

    // ADD WISH BOOK 
    public function addWishBook($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO books (isbn10_book, isbn13_book, title_book, author_book, cover_book, publisher_book, published_date_book, page_count_book, short_description_book, description_book, wish_book, favorite_book, lend_book, date_add_book, id_user ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, 0, NOW(), ?)');
        $addWishBook = $req->execute(array($isbn10, $isbn13, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser));
        return $addWishBook;
    }

    // COUNT WISH BOOK
    public function wishBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND wish_book = 1 AND lend_book = 0');
        $req->execute(array($idUser));
        $wishBookCount = $req->fetch();
        return $wishBookCount['total'];
    }

    // LIST WISH BOOKS
    public function listWishBooks($idUser, $sortKey, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, author_book, cover_book, wish_book, id_user FROM books WHERE wish_book = 1 AND id_user = ? ORDER BY $sortKey LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $listWishBooks = $req->fetchAll();
        $req->closeCursor();
        return $listWishBooks;
    } 

    // ADD WISH BOOK ON BOOKCASE
    public function addWishToBookcase($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET wish_book = 0 WHERE id_book = ? AND id_user = ?');
        $addWishToBookcase = $req->execute(array($idBook,$idUser));
        return $addWishToBookcase;
    }

    // GET SELECTED BOOK
    public function getBook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM books WHERE id_book = ? AND id_user = ?");
        $req->execute(array($idBook,$idUser));
        $book = $req->fetch();
        $req->closeCursor();
        return  $book;
    } 

    // ADD BOOK TO FAVORITES BOOKCASE
    public function addToFavoritesBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET favorite_book = 1 WHERE id_book = ? AND id_user = ?');
        $addToFavoritesBooks = $req->execute(array($idBook,$idUser));
        return $addToFavoritesBooks;
    }

    // TAKE BACK BOOK FROM FAVORITES BOOKCASE
    public function takeBackFromFavoritesBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET favorite_book = 0 WHERE id_book = ? AND id_user = ?');
        $takeBackFavoritesBooks = $req->execute(array($idBook,$idUser));
        return $takeBackFavoritesBooks;
    }

    // COUNT FAVORITES BOOKS
    public function favoritesBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND favorite_book = 1 AND lend_book = 0');
        $req->execute(array($idUser));
        $favoritesBookCount = $req->fetch();
        return $favoritesBookCount['total'];
    }

    // LIST FAVORITES BOOKS ON FAVORITES BOOKCASE
    public function listFavoritesBooks($idUser, $sortKey, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, author_book, cover_book, favorite_book, id_user FROM books WHERE favorite_book = 1 AND id_user = ? ORDER BY $sortKey LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $favoritesBooks = $req->fetchAll();
        $req->closeCursor();
        return $favoritesBooks;
    } 

    // ADD BOOK TO LEND BOOK BOOKCASE
    public function lendABook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET lend_book = 1 WHERE id_book = ? AND id_user = ?');
        $lendABook = $req->execute(array($idBook,$idUser));
        return $lendABook;
    }

    // TAKE BACK BOOK FROM LENT BOOKCASE
    public function takeBackFromLentBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET lend_book = 0 WHERE id_book = ? AND id_user = ?');
        $takeBackFromLentBooks = $req->execute(array($idBook,$idUser));
        return $takeBackFromLentBooks;
    }

    // COUNT LENT BOOKS
    public function lentBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND lend_book = 1');
        $req->execute(array($idUser));
        $lentBookCount = $req->fetch();
        return $lentBookCount['total'];
    }

    // LIST LENT BOOKS ON LENT BOOKCASE
    public function listLentBooks($idUser, $sortKey, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, author_book, cover_book, lend_book, id_user FROM books WHERE lend_book = 1 AND id_user = ? ORDER BY $sortKey LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $listLentBooks = $req->fetchAll();
        $req->closeCursor();
        return $listLentBooks;
    } 

    // UPDATE INFOS BOOK
    public function updateInfosBook($titleBook, $authorBook, $coverBook, $descriptionBook, $idBook, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET title_book = ?, author_book = ?, cover_book = ? , description_book = ? WHERE id_book = ? AND id_user = ?');
        $updateInfosBook = $req->execute(array($titleBook, $authorBook, $coverBook, $descriptionBook, $idBook, $idUser));
        return $updateInfosBook;
    }

    // DELETE SELECTED BOOK
    public function deleteBook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM books WHERE id_book = ? AND id_user = ?');
        $deleteBook = $req->execute(array($idBook,$idUser));
        return $deleteBook;
    }
    
}
