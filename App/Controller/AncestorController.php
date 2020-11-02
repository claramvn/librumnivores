<?php

namespace App\Controller;

//use \App\Model\UserManager;

class AncestorController
{

    /**************  NETTOYAGE PARAMETRES **************/

    protected function cleanParam($param)
    {
        $clean = trim(htmlspecialchars($param));
        return $clean;
    }

    /**************  NETTOYAGE ADDR EMAIL **************/

    public function cleanEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $email;
    }

    /**************  METHOD OF HASH **************/

    protected function getPowerfulHash($eltHash)
    {
        $combo = $eltHash . "essaiesDeTrouverMonHash2020";
        $hashCombo = hash("sha256", $combo);
        return $hashCombo;
    }
    
}
