<?php

namespace Controller;

use Core\Controller;

class HomeController extends Controller
{
    public function init()
    {
        //do something before each action
        //acting each time
        echo "This is init...\n";
    }

    public function __construct()
    {
        //do something only before the first action 
        //acting once
        echo "This is construct...\n";
    }
    public function getIndex()
    {
        echo "This is action index...\n";
    }
}
