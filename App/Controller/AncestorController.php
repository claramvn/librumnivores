<?php

namespace App\Controller;

use \App\Model\UserManager;

class AncestorController
{

    // CLEAN SETTINGS 
    protected function cleanParam($param)
    {
        $clean = trim(htmlspecialchars($param));
        return $clean;
    }

    // CLEAN EMAIL
    protected function cleanEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $email;
    }

    // METHOD OF HASH 
    protected function getPowerfulHash($eltHash)
    {
        $combo = $eltHash . "essaiesDeTrouverMonHash2020";
        $hashCombo = hash("sha256", $combo);
        return $hashCombo;
    }

    // USER LOGGED 
    protected function isLogged()
    {
        if (isset($_SESSION['id_user']) && isset($_SESSION['id_hash_user'])) {
            $id = $_SESSION['id_user'];

            $userManager = new UserManager();
            $this->user = $userManager->getUserById($id);

            $eltHash = $this->user['id_user'];

            $hash1 = $_SESSION['id_hash_user'];
            $hash2 = $this->getPowerfulHash($eltHash);
       
            if ($hash1 === $hash2) {
                return true;
            } else {
                return false;
            }
             
        } else {
            return false;
        }
    }

    // ADMIN
    protected function isAdmin()
    {
        if ($this->isLogged()) {
            if ($this->user['rank_user'] !== "1") {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    // DATE PROCESSING
    protected function dateUsToDateFr($date)
    {
        if(substr_count($date, '-') > 1) {
            $formatUs = explode('-', $date);
            $segmentYear = $formatUs[0];
            $segmentMonth = $formatUs[1];
            $segmentDay = $formatUs[2];
            $dateFr = $segmentDay . '/' . $segmentMonth . '/' . $segmentYear;
            return $dateFr;
        } else if (substr_count($date, '-') > 0) {
            $formatUs = explode('-', $date);
            $segmentYear = $formatUs[0];
            $segmentMonth = $formatUs[1];
            $dateFr = '__/' . $segmentMonth . '/' . $segmentYear;
            return $dateFr;
        } else {
            return $date;
        }
    }
    
}
