<?php
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
