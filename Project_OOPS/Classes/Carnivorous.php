<?php
class Carnivorous extends Animal 
{
    public $name;
    
    public static function description()
    {
        echo "I have two eyes.<br>";
    }

    public function intro()
    {
        $this->welcome();
        self::description();
        parent::description();
        echo "My name is $this->name and I eat meat !! <br>";
    }
}