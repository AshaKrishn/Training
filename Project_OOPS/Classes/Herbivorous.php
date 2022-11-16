<?php
class Herbivorous extends Animal
{
    public $name;
    
    protected function intro()
    {
        $this->welcome();
        echo "My name is $this->name and I eat plants !! <br>";
    }
}