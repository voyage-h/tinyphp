<?php

namespace Controller;

use Core\Controller;

class WelcomeController extends Controller
{
    public function getHome()
    {
        return $this->render('home', ['name' => 'zz']);
    }
}
