<?php

class Animal
{
    public $type;
    public $colour;
    private static $legs = 4;
    public static $tails = 1;

    public static function description()
    {
        echo "I have ".self::$legs." legs. <br>";
    }
    
    public function welcome()
    {
        echo "Hi I am a $this->colour $this->type...!! <br>";
    }    
}
