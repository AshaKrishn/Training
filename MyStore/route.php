<?php

class route
{
    private $uri = array();
    private $class = array();
    private $method = array();

    public function add($uri, $class = null, $method = null)
    {
        $this->uri[] = $uri;
        if ($class != null) {
            $this->class[] = $class;
        }
        if ($method != null) {
            $this->method[] = $method;
        }
    }

    public function routeToThisUrl()
    {
        $getUri = isset($_REQUEST['uri']) ? $_REQUEST['uri'] : '/';
        $key = array_search ($getUri, $this->uri);
        if($key !== false) {  
            $class = $this->class[$key];
            $method = $this->method[$key];
            (new $class())->$method();
        } else {
            $host = $_SERVER['HTTP_HOST'];
            $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            header("Location:http://$host$uri/");
            exit;
        }
    }
}
