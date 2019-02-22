<?php 

namespace Core;

use Dispatcher\Container;

class Response Extends Container 
{
    public function __call($method,$args) 
    {
        dd($method,$args);    
    }
    public function setHeader(array $data) 
    {
        foreach($data as $k => $v) {
            header("$k : $v");    
        }    
    }
    public function setHttpCode($code) 
    {
        switch($code) {
            //information
            case 0:  $info = 'Unable to access';break;
            case 100:$info = 'Continue';break;
            case 101:$info = 'Switching Protocols';break;

            //success
            case 200:$info = 'OK';break;
            case 201:$info = 'Created';break;
            case 202:$info = 'Accepted';break;
            case 203:$info = 'Non-Authoritative Information';break;
            case 204:$info = 'No Content';break;
            case 205:$info = 'Reset Content';break;
            case 206:$info = 'Partial Content';break;
            
            //redirect
            case 300:$info = 'Multiple Choices';break;
            case 301:$info = 'Moved Permanently';break;
            case 302:$info = 'Found';break;
            case 303:$info = 'See Other';break;
            case 304:$info = 'Not Modified';break;
            case 305:$info = 'Use Proxy';break;
            case 306:$info = 'Unused';break;
            case 307:$info = 'Temporary Redirect';break;

            //client error
            case 400:$info = 'Bad Request';break;
            case 401:$info = 'Unauthorized';break;
            case 402:$info = 'Payment Required';break;
            case 403:$info = 'Forbidden';break;
            case 404:$info = 'Not Found';break;
            case 405:$info = 'Method Not Allowed';break;
            case 406:$info = 'Not Acceptable';break;
            case 407:$info = 'Proxy Authentication Required';break;
            case 408:$info = 'Request Timeout';break;
            case 409:$info = 'Conflict';break;
            case 410:$info = 'Gone';break;
            case 411:$info = 'Length Required';break;
            case 412:$info = 'Precondition Failed';break;
            case 413:$info = 'Request Entity Too Large';break;
            case 414:$info = 'Request-URI Too Long';break;
            case 415:$info = 'Unsupported Media Type';break;
            case 416:$info = 'Requested Range Not Satisfiable';break;
            case 417:$info = 'Expectation Failed';break;

            //server error
            case 500:$info = 'Internal Server Error';break;
            case 501:$info = 'Not Implemented';break;
            case 502:$info = 'Bad Gateway';break;
            case 503:$info = 'Service Unavailable';break;
            case 504:$info = 'Gateway Timeout';break;
            case 505:$info = 'HTTP Version Not Supported';break;

            default: Error::fatal("Invalid http response code $code");
        }
        header("HTTP/1.0 $code $info");    
    }
    
}
