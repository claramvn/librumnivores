<?php

namespace App\Controller;

class FrontController extends AncestorController
{
    // HOME
    public function home()
    {
        require('App/View/home.php');
    }

    // LEGALS MENTIONS
    public function mentions()
    {
        require('App/View/mentions.php');
    }

    // PRIVACY POLICY
    public function privacyPolicy()
    {
        require('App/View/policy.php');
    }

    // PAGE ERROR
    public function error404()
    {
        require('App/View/error.php');
    }

}
