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

class Herbivorous extends Animal
{
    public $name;
    protected function intro()
    {
        $this->welcome();
        echo "My name is $this->name and I eat plants !! <br>";
    }
}

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

final class Dog extends Omnivorous
{
    private function sound()
    {
        echo "Woof Woof..!! <br>";
    }
    private function habitat()
    {
        echo "I live in a Kennel <br>";
    }
    public function aboutMe()
    {
        $this->intro();
        $this->sound();
        $this->habitat();
    }
}

final class Cow extends Herbivorous
{
    private function sound()
    {
        echo "Moo Moo Moo !! <br>";
    }
    private function habitat()
    {
        echo "I live in a Farm <br>";
    }
    public function aboutMe()
    {
        $this->intro();
        $this->sound();
    }
}

$carnivorous = new Carnivorous();
$carnivorous->type = "Tiger";
$carnivorous->colour = "Brown";
$carnivorous->name = "Diego";
$carnivorous->intro();
echo "=====================================<br>";

$cow = new Cow();
$cow->type = "Cow";
$cow->colour = "Grey";
$cow->name = "Kunjumol";
$cow->aboutMe();
echo "=====================================<br>";

$dog = new Dog();
$dog->type = "Dog";
$dog->colour = "Black";
$dog->name = "Mia";
$dog->aboutMe();
echo "=====================================<br>";

