<?php

class route 
{
    private $uri = array();
    private $class = array();
    private $method = array();

    public function add($uri,$class = null,$method = null) 
    {
        $this->uri[] = $uri;
        if ($class != null) {
            $this->class[] = $class;
        }
        if ($method != null) {
            $this->method[] = $method;
        }
        
    }

    public function checkMatch()
    {
        if (isset($_GET['uri'])){
            $getUri = $_GET['uri'];
        } else if (isset($_POST['uri'])) {
            $getUri = $_POST['uri'];
        }else {
            $getUri = '/';
        }
        foreach ($this->uri as $key=>$val) {
            if (preg_match("#^$val#",$getUri)) {
                $class = $this->class[$key];
                $method = $this->method[$key];
                (new $class())->$method();

            } 
        }
    }
}
?>