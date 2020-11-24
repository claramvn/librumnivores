<?php

namespace App\Model;

class BookManager extends Manager
{
    // Add Book
    public function addBook($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO books (isbn_book, title_book, author_book, cover_book, publisher_book, published_date_book, page_count_book, short_description_book, description_book, wish_book, favorite_book, lend_book, date_add_book, id_user ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, NOW(), ?)');
        $addBook = $req->execute(array($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser));
        return $addBook;
    }

    // Book exist
    public function bookExist($isbn, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT isbn_book FROM books WHERE isbn_book = ? AND id_user = ?');
        $req->execute(array($isbn, $idUser));
        $bookExist = $req->fetch();
        $req->closeCursor();
        return $bookExist;
    }

    // Count Books
    public function bookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND wish_book = 0 AND lend_book = 0');
        $req->execute(array($idUser));
        $bookCount = $req->fetch();
        return $bookCount['total'];
    }

    // List Books
    public function listBooks($idUser, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, cover_book, wish_book, lend_book, date_add_book, id_user FROM books WHERE wish_book = 0 AND lend_book = 0 AND id_user = ? ORDER BY date_add_book LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $books = $req->fetchAll();
        $req->closeCursor();
        return $books;
    }

    // Add Wish Book
    public function addWishBook($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO books (isbn_book, title_book, author_book, cover_book, publisher_book, published_date_book, page_count_book, short_description_book, description_book, wish_book, favorite_book, lend_book, date_add_book, id_user ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, 0, NOW(), ?)');
        $addWishBook = $req->execute(array($isbn, $title, $author, $cover, $publisher, $publishedDate, $pageCount, $shortDescription, $description, $idUser));
        return $addWishBook;
    }

    // Count Wish Books
    public function wishBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND wish_book = 1 AND lend_book = 0');
        $req->execute(array($idUser));
        $wishBookCount = $req->fetch();
        return $wishBookCount['total'];
    }

    // List Wish Books
    public function listWishBooks($idUser, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, cover_book, wish_book, id_user FROM books WHERE wish_book = 1 AND id_user = ? ORDER BY date_add_book LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $listWishBooks = $req->fetchAll();
        $req->closeCursor();
        return $listWishBooks;
    } 

    // Add to bookcase
    public function addWishToBookcase($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET wish_book = 0 WHERE id_book = ? AND id_user = ?');
        $addWishToBookcase = $req->execute(array($idBook,$idUser));
        return $addWishToBookcase;
    }

    // Get selected Book
    public function getBook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM books WHERE id_book = ? AND id_user = ?");
        $req->execute(array($idBook,$idUser));
        $book = $req->fetch();
        $req->closeCursor();
        return  $book;
    } 

    // Count favorites Books
    public function favoritesBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND favorite_book = 1 AND lend_book = 0');
        $req->execute(array($idUser));
        $favoritesBookCount = $req->fetch();
        return $favoritesBookCount['total'];
    }

    // List Favorites Books
    public function listFavoritesBooks($idUser, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, cover_book, favorite_book, id_user FROM books WHERE favorite_book = 1 AND id_user = ? ORDER BY date_add_book LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $favoritesBooks = $req->fetchAll();
        $req->closeCursor();
        return $favoritesBooks;
    } 

    // Add to favorites books
    public function addToFavoritesBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET favorite_book = 1 WHERE id_book = ? AND id_user = ?');
        $addToFavoritesBooks = $req->execute(array($idBook,$idUser));
        return $addToFavoritesBooks;
    }

    // Take back from favorites books
    public function takeBackFromFavoritesBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET favorite_book = 0 WHERE id_book = ? AND id_user = ?');
        $takeBackFavoritesBooks = $req->execute(array($idBook,$idUser));
        return $takeBackFavoritesBooks;
    }

    // Lend a book
    public function lendABook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET lend_book = 1 WHERE id_book = ? AND id_user = ?');
        $lendABook = $req->execute(array($idBook,$idUser));
        return $lendABook;
    }

    // Take back from lent books
    public function takeBackFromLentBooks($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE books SET lend_book = 0 WHERE id_book = ? AND id_user = ?');
        $takeBackFromLentBooks = $req->execute(array($idBook,$idUser));
        return $takeBackFromLentBooks;
    }

    // Count lent Books
    public function lentBookCount($idUser) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) as total FROM books WHERE id_user = ? AND lend_book = 1');
        $req->execute(array($idUser));
        $lentBookCount = $req->fetch();
        return $lentBookCount['total'];
    }

    // List lent Books
    public function listLentBooks($idUser, $first, $perPage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT id_book, title_book, cover_book, lend_book, id_user FROM books WHERE lend_book = 1 AND id_user = ? ORDER BY date_add_book LIMIT $first, $perPage");
        $req->execute(array($idUser));
        $listLentBooks = $req->fetchAll();
        $req->closeCursor();
        return $listLentBooks;
    } 

    // Delete selected book
    public function deleteBook($idBook,$idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM books WHERE id_book = ? AND id_user = ?');
        $deleteBook = $req->execute(array($idBook,$idUser));
        return $deleteBook;
    }
    
}
