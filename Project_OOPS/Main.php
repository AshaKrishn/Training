<?php

spl_autoload_register(function ($class) {
    include 'Classes/'.$class . '.php';
});

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