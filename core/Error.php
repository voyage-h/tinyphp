<?php

namespace Core;

use Dispatcher\Container;

class Error extends Container
{
    public function init() 
    {
        if (!Config::get('debug')) {
            $this->response->setHttpCode(403);
            exit("Unexpected error");
        }
        $message = func_get_args()[0];
        $this->error = new \Exception($message);
    }

    public function __call($method,$args) 
    {
        if (empty($args[1])) {
            $error = new \Exception($args[0]);
            $trace = $error->getTraceAsString();
        } else {
            $trace = $args[1];
        }
        $this->display($method, trim($trace));
        if ('fatal' == $method) {
            exit;
        }
    }

    private function display($type, $trace) 
    {
        $trace = explode('#', trim($trace,'#'));
        $error_html = '';
        foreach($trace as $error) {
            $error_html .= "<p>$error</p>";
        }
        $message = $this->error->getMessage();
        $title = strtoupper($type);
        require "html/error.php";
    }

}
