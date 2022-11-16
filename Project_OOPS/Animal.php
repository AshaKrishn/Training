<?php

class Animal {
    public $type;
    public $colour;
    
    private static $legs = 4;
    public static $tails = 1;

    public static function Description() {
        echo "I have ".self::$legs." legs. <br>";
    }

    public function Welcome(){
        echo "Hi I am a $this->colour $this->type...!! <br>";
        
    }
    
   
}

class Carnivorous extends Animal {
    public $name;
    public function Intro() {
        $this->Welcome();
        self::Description();
        echo "My name is $this->name and I eat meat !! <br>";
    }

}

class Herbivorous extends Animal {
    public $name;
    protected function Intro() {
        $this->Welcome();
        echo "My name is $this->name and I eat plants !! <br>";
    }
}

class Omnivorous extends Animal {
    public $name;
    protected function Intro() {
        $this->Welcome();
        echo "I have ".self::$tails." tail.<br>";
        echo "My name is $this->name and I eat both plants and meat !! <br>";
    }
    
}

Final class Dog extends Omnivorous {
    private function Sound() {
        echo "Woof Woof..!! <br>";
    }
    private function Habitat(){
        echo "I live in a Kennel <br>";
    }

    public function AboutMe(){
        $this->Intro();
        $this->Sound();
        $this->Habitat();
    }
    
}

Final class Cow extends Herbivorous {
    private function Sound() {
        echo "Moo Moo Moo !! <br>";
    }
    private function Habitat(){
        echo "I live in a Farm <br>";
    }
    public function AboutMe(){
        $this->Intro();
        $this->Sound();
    }
    
}

$carnivorous = new Carnivorous();
$carnivorous->type = "Tiger";
$carnivorous->colour = "Brown";
$carnivorous->name = "Diego";
$carnivorous->Intro();
echo "=====================================<br>";

$cow = new Cow();
$cow->type = "Cow";
$cow->colour = "Grey";
$cow->name = "Kunjumol";
$cow->AboutMe();
echo "=====================================<br>";

$dog = new Dog();
$dog->type = "Dog";
$dog->colour = "Black";
$dog->name = "Mia";
$dog->AboutMe();
echo "=====================================<br>";

?>