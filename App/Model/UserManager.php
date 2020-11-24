<?php

namespace App\Model;

class UserManager extends Manager
{
    // GET USER BY NAME
    public function getUserByName($name)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE name_user = ?');
        $req->execute(array($name));
        $user = $req->fetch();
        return $user;
    }

    // GET USER BY ID
    public function getUserById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE id_user = ?');
        $req->execute(array($id));
        $user = $req->fetch();
        return $user;
    }

    // GET USER EMAIL
    public function emailExist($email)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT email_user FROM users WHERE email_user = ?');
        $req->execute(array($email));
        $emailExist = $req->fetch();
        return $emailExist;
    }

    // ADD USER
    public function addUser($name, $email, $password, $avatar)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users (name_user, email_user, pass_user, avatar_user, rank_user) VALUES (?, ?, ?, ?, 0)');
        $addUser = $req->execute(array($name, $email, $password, $avatar));
        return $addUser;
    }
}
