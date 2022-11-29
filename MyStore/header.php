<?php
if (isset($_SESSION['userid'])) {
    echo "welcome ".$_SESSION['username'] ."<br>";
    echo "<a href='index.php'>Home</a>    ";
    echo "<a href='viewCart'>Cart</a>    ";
    echo "<a href='logout'>Logout</a><br>";
} 
