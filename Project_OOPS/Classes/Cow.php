<?php
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