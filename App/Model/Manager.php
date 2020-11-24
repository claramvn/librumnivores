<?php

namespace App\Model;

use Exception;

class Manager
{
    protected function dbConnect()
    {
        try {
            $db = new \PDO('mysql:host=localhost;dbname=librumnivores;charset=utf8', 'root', '');
            return $db;
        } catch (Exception $e) {
            require_once('App/View/error.php');
        }
    }
}