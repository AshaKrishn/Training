<?php
class Omnivorous extends Animal
{
    public $name;
    
    protected function intro()
    {
        $this->welcome();
        echo "I have ".self::$tails." tail.<br>";
        echo "My name is $this->name and I eat both plants and meat !! <br>";
    }
}
