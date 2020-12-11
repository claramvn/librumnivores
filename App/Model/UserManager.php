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
        $req = $db->prepare('INSERT INTO users (name_user, email_user, pass_user, avatar_user, token_user, rank_user) VALUES (?, ?, ?, ?, " ", 0)');
        $addUser = $req->execute(array($name, $email, $password, $avatar));
        return $addUser;
    }

    // SET TOKEN
    public function setTokenUser($token, $email)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET token_user = ? WHERE email_user = ?');
        $setTokenUser = $req->execute(array($token, $email));
        return $setTokenUser;
    }

    // GET USER BY TOKEN
    public function getUserByToken($token)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT token_user FROM users WHERE token_user = ?');
        $req->execute(array($token));
        $user = $req->fetch();
        return $user;
    }

    // RESET PASSWORD
    public function resetPass($password, $token)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET pass_user = ? WHERE token_user = ?');
        $resetPass = $req->execute(array($password, $token));
        return $resetPass;
    }

    // UPDATE PROFIL USER
    public function updateProfilUser($name, $email, $avatar, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET name_user = ?, email_user = ?, avatar_user = ? WHERE id_user = ?');
        $updateProfilUser = $req->execute(array($name, $email, $avatar, $id));
        return $updateProfilUser;
    }

    // DELETE USER ACCOUNT
    public function deleteUserAccount($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM users WHERE id_user = ?');
        $deleteUserAccount = $req->execute(array($id));
        return $deleteUserAccount;
    }
}
