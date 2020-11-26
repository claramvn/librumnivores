<?php

namespace App\Controller;

use \App\Model\UserManager;

class UserController extends AncestorController
{

    function __construct()
	{
		$this->userManager = new UserManager();
	}

    // CHECK PASSWORD LENGTH
    public function checkPasswordLength($password)
    {
        $passLength = strlen($password);
        if ($passLength >= 6) {
            return true;
        } else {
            return false;
        }
    }

    // REGISTER
    public function register()
    {
        $name="";
        $email="";
        $password="";
        $confPassword="";

        $errors=[];

        if(isset($_POST['button_register'])) {
            $name=$this->cleanParam($_POST['user_name']);
            $email=$this->cleanParam($_POST['user_email']);
            $password=$this->cleanParam($_POST['user_pass']);
            $confPassword=$this->cleanParam($_POST['user_confirm_pass']);
            $avatar = "thumbnail.jpg";

            if(empty($name) || empty($email) || empty($password) || empty($confPassword)) {
                $errors['empty_fields_registration']= '<span class="cross"><i class="fas fa-times"></i></span> Oups, vous ne pouvez pas laisser de champs vides.';
            }

            $user = $this->userManager->getUserByName($name);

            if ($user['name_user'] === $name) {
                $errors['user_exist_register'] = '<span class="cross"><i class="fas fa-times"></i></span> Nom d\'utilisateur déjà existant.';
            }

            if(!$this->cleanEmail($email)) {
                $errors['invalid_email_register'] = '<span class="cross"><i class="fas fa-times"></i></span> Le format de l\'adresse e-mail n\'est pas valide.';
            }

            $emailExist = $this->userManager->emailExist($email);
            if ($emailExist['email_user'] === $email) {
                $errors['exist_email_register'] = '<span class="cross"><i class="fas fa-times"></i></span> Adresse e-mail déjà utilisée.';
            }

            if(!$this->checkPasswordLength($password)) {
                $errors['password_length_register'] = '<span class="cross"><i class="fas fa-times"></i></span> Le mot de passe doit comporter minimum 6 caractères.';
            } 

            if($password !== $confPassword) {
                $errors['not_same_passwords_register'] = '<span class="cross"><i class="fas fa-times"></i></span> Veuillez renseigner un mot de passe identique au mot de passe de confirmation.';
            }

            if(!$errors) {
                $eltHash = $password;
                $password = $this->getPowerfulHash($eltHash);

                $addUser = $this->userManager->addUser($name,$email,$password,$avatar);

                if($addUser !== false) {
                    $user = $this->userManager->getUserByName($name);
                    $eltHash = $user['id_user'];
                    $_SESSION['id_user'] = $eltHash;
                    $_SESSION['id_hash_user'] = $this->getPowerfulHash($eltHash);

                    header('Location: index.php');
                }
            }
        }

        require('App/View/register.php');
    }

    // CONNECTION
    public function connection()
    {
        $name="";

        $errors=[];

        if(isset($_POST['button_connection'])) {
        $name=$this->cleanParam($_POST['user_name']);
        $eltHash=$this->cleanParam($_POST['user_pass']);
        $password=$this->getPowerfulHash($eltHash);

        if(empty($name) || empty($password)) {
            $errors['empty_fields_connection']= '<span class="cross"><i class="fas fa-times"></i></span> Oups, vous ne pouvez pas laisser de champs vides.';
        }

        $user = $this->userManager->getUserByName($name);

        if ($user['name_user'] !== $name) {
            $errors['error_connection'] = '<span class="cross"><i class="fas fa-times"></i></span> Erreur Authentification : Identifiants incorrects.';
        }

        if ($user['pass_user'] !== $password) {
            $errors['error_connection'] = '<span class="cross"><i class="fas fa-times"></i></span> Erreur Authentification : Identifiants incorrects.';
        }

        if(!$errors) {
            $eltHash = $user['id_user'];
            $_SESSION['id_user'] = $eltHash;
            $_SESSION['id_hash_user'] = $this->getPowerfulHash($eltHash);

            header('Location: index.php?action=listBooks');
        }

        }

        require('App/View/connection.php');
    }

    // LOGOUT
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    // CHECK TEXTAREA LENGTH
    public function checkMessageLength($message)
    {
        $messLength = strlen($message);
        if ($messLength >= 15) {
            return true;
        } else {
            return false;
        }
    }

    // CONTACT
    public function contact()
    {
        $name= "";
        $email= "";
        $message= "";

        $errors = [];
        $success = "";

        if(isset($_POST['button_contact'])) {
            $name=$this->cleanParam($_POST['user_name']);
            $email=$this->cleanParam($_POST['user_email']);
            $message=$this->cleanParam($_POST['user_message']);

            if(empty($name) || empty($email) || empty($message)) {
                $errors['empty_fields_contact'] = '<i class="fas fa-times"></i> Oups, vous ne pouvez pas laisser de champs vides.';
            } 

            if(!$this->cleanEmail($email)) {
                $errors['invalid_email_contact'] = '<i class="fas fa-times"></i> Le format de l\'adresse e-mail n\'est pas valide.';
            }

            if (!$this->checkMessageLength($message)) {
                $errors['message_length_contact'] = '<i class="fas fa-times"></i> Oups, votre message est trop court.';
            }

            if(!$errors) {
                //Version d'encodage mail
                $header='MIME-Version: 1.0' . "\r\n";
                $header.='From:"Librumnivores"<claramvnbrg@gmail.com>'."\n";
                $header.='Content-Type:text/html; charset="uft-8"'."\n";
                $header.='Content-Transfer-Encoding: 8bit';

                $text = '<h1>Message envoyé depuis la page Contact de Librumnivores</h1>
                <p>Nom : ' . $name . '</p><br><br>
                <p>Email : ' . $email . '</p><br><br>
                <p>Message : ' . nl2br($message) . '</p>';

                //mail('claramvnbrg@gmail.com', "Envoi depuis page Contact - Librumnivores", $text, $header);

                $success= "Votre message a bien été transmis. Merci";

            }
        }
        require('App/View/contact.php');
    }

    // UPDATE PROFIL USER
    public function updateProfil()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $id = $this->user['id_user'];
        $name = $this->user['name_user'];
        $email = $this->user['email_user'];
        $avatar = $this->user['avatar_user'];

        $errors = [];
        $success = [];

        require('App/View/updateProfil.php');
    }
    
}