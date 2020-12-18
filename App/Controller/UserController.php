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
        $name = "";
        $email = "";
        $password = "";
        $confPassword = "";

        $errors = [];

        if(isset($_POST['button_register'])) {
            $name = $this->cleanParam($_POST['user_name']);
            $email = $this->cleanParam($_POST['user_email']);
            $password = $this->cleanParam($_POST['user_pass']);
            $confPassword = $this->cleanParam($_POST['user_confirm_pass']);
            $avatar = "thumbnail.jpg"; 

            if(empty($name) || empty($email) || empty($password) || empty($confPassword)) {
                $errors['empty_fields_registration']= 'Oups, il est impossible de laisser un champ vide.';
            }

            $user = $this->userManager->getUserByName($name);

            if (isset($user['name_user']) && $user['name_user'] === $name) {
                $errors['user_exist_register'] = 'Nom d\'utilisateur déjà existant.';
            }

            if(!$this->cleanEmail($email)) {
                $errors['invalid_email_register'] = 'Le format de l\'adresse e-mail n\'est pas valide.';
            }

            $emailExist = $this->userManager->emailExist($email);
            if (isset($emailExist['email_user']) && $emailExist['email_user'] === $email) {
                $errors['exist_email_register'] = 'Adresse e-mail déjà utilisée.';
            }

            if(!$this->checkPasswordLength($password)) {
                $errors['password_length_register'] = 'Le mot de passe doit comporter minimum 6 caractères.';
            } 

            if($password !== $confPassword) {
                $errors['not_same_passwords_register'] = 'Veuillez renseigner un mot de passe identique au mot de passe de confirmation.';
            }

            if(!$errors) {
                $eltHash = $password;
                $password = $this->getPowerfulHash($eltHash);

                $addUser = $this->userManager->addUser($name, $email, $password, $avatar);

                $user = $this->userManager->getUserByName($name);
                $eltHash = $user['id_user'];
                $_SESSION['id_user'] = $eltHash;
                $_SESSION['id_hash_user'] = $this->getPowerfulHash($eltHash);

                header('Location: index.php?action=listBooks&f=all');
            }
        }

        require('App/View/register.php');
    }

    // CONNECTION
    public function connection()
    {
        $name = "";

        $errors = [];

        if(isset($_POST['button_connection'])) {
            $name = $this->cleanParam($_POST['user_name']);
            $eltHash = $this->cleanParam($_POST['user_pass']);
            $password = $this->getPowerfulHash($eltHash);

            if(empty($name) || empty($password)) {
                $errors['empty_fields_connection']= 'Oups, il est impossible de laisser un champ vide.';
            }

            $user = $this->userManager->getUserByName($name);

            if (!isset($user['name_user']) || $user['name_user'] !== $name) {
                $errors['error_connection'] = 'Erreur Authentification : Identifiants incorrects.';
            }

            if (!isset($user['pass_user']) || $user['pass_user'] !== $password) {
                $errors['error_connection'] = 'Erreur Authentification : Identifiants incorrects.';
            } 

            if(!$errors) {
                $eltHash = $user['id_user'];
                $_SESSION['id_user'] = $eltHash;
                $_SESSION['id_hash_user'] = $this->getPowerfulHash($eltHash);

                header('Location: index.php?action=listBooks&f=all');
            }

        }

        require('App/View/connection.php');
    }

    public function resetPassRequest() {

        $email = "";

        $errors = [];
        $success = [];

        if(isset($_POST['button_reset_pass_request'])) {
            $email = $this->cleanParam($_POST['user_email_reset_pass_request']);

            if(empty($email) ) {
                $errors['empty_fields_reset_pass_request']= 'Oups, il est impossible de laisser un champ vide.';
            }

            if(!$this->cleanEmail($email)) {
                $errors['invalid_email_reset_pass_request'] = 'Le format de l\'adresse e-mail n\'est pas valide.';
            }

            $emailExist = $this->userManager->emailExist($email);
            if (!isset($emailExist['email_user']) || $emailExist['email_user'] !== $email) {
                $errors['exist_email_register'] = 'Adresse e-mail inconnue.';
            }

            if(!$errors) {
                $rand = rand(); 
                $token = md5($rand);

                $setTokenUser = $this->userManager->setTokenUser($token, $email);

                if($setTokenUser) {
                    $subject = 'Envoi depuis la page : nouveau mot de passe - Librumnivores.';
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'From:"Librumnivores"<claramvnbrg@gmail.com>'."\n";
                    $headers .= 'Content-Type:text/html; charset="uft-8"'."\n";
                    $headers .= 'Content-Transfer-Encoding: 8bit';
                    $headers .= 'Date:' . date("D, j M Y H:i:s -0600") .  "\n";

                    $text = '<h1>LIBRUMNIVORES</h1>
                    <p><a href="https://librumnivores.claramvn.fr/index.php?action=resetPass&token='. $token . '">Voici le lien pour changer votre mot de passe.</a></p>';
        
                    mail($email, mb_encode_mimeheader($subject), $text, $headers);

                    $success['valid_email_reset_pass_request'] = 'Nous vous avons envoyé un e-mail pour réinitialiser votre mot de passe.<br/><br/>Pour créer votre nouveau mot de passe, il vous suffit de cliquer sur le lien contenu dans l\'e-mail et d\'en saisir un nouveau.<br/><br/>Vous n\'avez pas reçu cet e-mail ? Vérifiez votre courrier indésirable ou toute autre adresse e-mail liée à votre compte LIBRUMNIVORES.';
                } else {
                    header('Location: index.php?action=error404');
                }

            }
        };


        require('App/View/resetPassRequest.php');
    }

    public function resetPass() {

        $errors = [];
        $success = [];

        if(isset($_POST['button_reset_pass'])) {

            $password = $this->cleanParam($_POST['user_reset_pass']);
            $confPassword = $this->cleanParam($_POST['user_confirm_reset_pass']);
            $token = $this->cleanParam($_GET['token']);

            $user = $this->userManager->getUserByToken($token);
            if (!$user) {
                $errors['empty_fields_reset_pass']= 'Vous êtes un tricheur. Librumnivores n\'aime pas les tricheurs.';
            } 

            if(empty($password) || empty($confPassword)) {
                $errors['empty_fields_reset_pass']= 'Oups, il est impossible de laisser un champ vide.';
            }
    
            if(!$this->checkPasswordLength($password)) {
                $errors['password_length_reset_pass'] = 'Le mot de passe doit comporter minimum 6 caractères.';
            } 
    
            if($password !== $confPassword) {
                $errors['not_same_passwords_reset_pass'] = 'Veuillez renseigner un mot de passe identique au mot de passe de confirmation.';
            }
            
            if(!$errors) {
                $eltHash = $password;
                $password = $this->getPowerfulHash($eltHash);

                $resetPass = $this->userManager->resetPass($password, $token);

                if($resetPass !== false) {
                    header('Location: index.php?action=connection');
                } else {
                    header('Location: index.php?action=error404');
                }
            }
        }

        require('App/View/resetPass.php');
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

        if ($this->isLogged()) {
            $name = $this->user['name_user'];
            $email = $this->user['email_user'];
        } else {
            $name = "";
            $email = "";
        }
        $message= "";

        $errors = [];
        $success = "";

        if(isset($_POST['button_contact'])) {

            $name=$this->cleanParam($_POST['user_name']);
            $email=$this->cleanParam($_POST['user_email']);
            $message=$this->cleanParam($_POST['user_message']);

            if(empty($name) || empty($email) || empty($message)) {
                $errors['empty_fields_contact'] = 'Oups, il est impossible de laisser un champ vide.';
            } 

            if(!$this->cleanEmail($email)) {
                $errors['invalid_email_contact'] = 'Le format de l\'adresse e-mail n\'est pas valide.';
            }

            if (!$this->checkMessageLength($message)) {
                $errors['message_length_contact'] = 'Oups, votre message est un peu trop court.';
            }

            if(!$errors) {
                $to = 'claramvn@hotmail.fr';
                $subject = 'Envoi depuis la page : Contact - Librumnivores';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From:"Librumnivores"<claramvnbrg@gmail.com>'."\n";
                $headers .= 'Content-Type:text/html; charset="uft-8"'."\n";
                $headers .= 'Content-Transfer-Encoding: 8bit';
                $headers .= 'Date:' . date("D, j M Y H:i:s -0600") .  "\n";

                $text = '<h1>Librumnivores</h1>
                <p>Nom : ' . $name . '</p><br><br>
                <p>Email : ' . $email . '</p><br><br>
                <p>Message : ' . nl2br($message) . '</p>';

                $test = mail($to, mb_encode_mimeheader($subject), $text, $headers);

                if ($test) {
                    $success= "Votre message a bien été transmis. Merci";
                }
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

        if (isset($_POST['button_update_profil'])) {
            $name = $this->cleanParam($_POST['user_name']);
            $email = $this->cleanParam($_POST['user_email']);

            // NAME TREATMENT
            if ($this->user['name_user'] !== $name) {
                $user = $this->userManager->getUserByName($name);
                
                if (isset($user['name_user']) &&  $user['name_user'] === $name) {
                    $errors['name_user_profil'] = "Nom d'utilisateur déjà existant";
                }
            
                if (!$errors) {
                    $success['name_user_profil'] = "Le pseudo a bien été modifié";
                } else {
                    $name = $this->user['name_user'];
                }
            }


            // EMAIL TREATMENT
            if ($this->user['email_user'] !== $email) {
                $emailExist = $this->userManager->emailExist($email);

                if (isset($emailExist['email_user']) && $emailExist['email_user'] === $email) {
                    $errors['email_user_profil'] = "Adresse e-mail déjà utilisée ";
                }
        
                if (!$this->cleanEmail($email)) {
                    $errors['email_user_profil'] = "Le format de l'adresse e-mail n'est pas valide.";
                }
        
                if (!$errors) {
                    $success['email_user_profil'] = "L'adresse e-mail a bien été modifiée";
                } else {
                    $email = $this->user['email_user'];
                }
            }

            // FILE TREATMENT
            if (isset($_FILES["user_avatar"]) && $_FILES["user_avatar"]["error"] == 0) {
                $file = $_FILES['user_avatar'];
                $extensionUpload = $this->checkExtensionFileUpload($file);
                $extensionAllowed = $this->checkIfExtensionIsAllowed();

                if (!$this->checkMaxSize($file)) {
                    $errors['size_avatar_profil'] = "Impossible de modifier l'image : le fichier est trop volumineux";
                }

                if (!in_array($extensionUpload, $extensionAllowed)) {
                    $errors['extension_avatar_profil'] = "Impossible de modifier l'image : le fichier n'est pas au format jpg/jpeg/png/gif";
                }

                if (!$errors) {
                    $nameFile = $this->renameFile($file, $extensionUpload);
                    $uploadAvatar = $this->uploadAvatarFile($file, $nameFile);

                    if ($this->user['avatar_user'] !== "thumbnail.jpg") {
                        unlink('Public/img/avatar/' . $this->user['avatar_user']);
                    }

                    $avatar = $nameFile;

                    $success['avatar_profil'] = "L'image a bien été modifiée";
                } else {
                    $avatar = $this->user['avatar_user'];
                }
            }

            $updateProfilUser = $this->userManager->updateProfilUser($name, $email, $avatar, $id);

            if (!$updateProfilUser) {
                $errors['req_profil'] = "Impossible de modifier le profil";
            }
        }

        require('App/View/updateProfil.php');
    }

    // DELETE USER ACCOUNT
    public function deleteUserAccount()
    {
        if (!$this->isLogged()) {
            header('Location: index.php');
        }

        $id = $this->user['id_user'];

        if ($this->user['avatar_user'] !== "thumbnail.jpg") {
            unlink('Public/img/avatar/' . $this->user['avatar_user']);
        }

        $deleteUserAccount = $this->userManager->deleteUserAccount($id);

        if ($deleteUserAccount === false) {
            $errors['req_delete_profil'] = "<span class='cross'><i class='fas fa-times'></i></span> Impossible de supprimer votre compte Librumnivores";
            header('Location: index.php?action=updateProfil');
        } else {
            header('Location: index.php');
        }
    }
    
}