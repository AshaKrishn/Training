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
        $flag = 0;
        $getUri = isset($_REQUEST['uri']) ? $_REQUEST['uri'] : '/';
        foreach ($this->uri as $key=>$val) {
            if ($val == $getUri) {
                $flag = 1;
                $class = $this->class[$key];
                $method = $this->method[$key];
                (new $class())->$method();
                exit;
            }
        }
        if ($flag == 0){
            $host = $_SERVER['HTTP_HOST'];
            $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            //echo "http://$host$uri/";
            header("Location:http://$host$uri/");
        }
        
    }
}
