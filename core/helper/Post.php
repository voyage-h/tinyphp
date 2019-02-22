<?php

namespace Helper;

use Dispatcher\Container;

class Post extends Container
{

    protected function filter()
    {
        $array = $_POST;
        while(list($key,$var) = each($array)) {
            if ($key != 'argc' && $key != 'argv' && (strtoupper($key) != $key || ''.intval($key) == "$key")) {
                if (is_string($var)) {
                    $array[$key] = stripslashes($var);
                }
                if (is_array($var)) {
                    $array[$key] = $this->stripslashes_array($var);
                }
            }
        }
        unset($_POST);
        return $array;
    }
}
