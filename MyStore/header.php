<?php
if (isset($_SESSION['userid'])) {
    echo "<a href='index.php'>Home</a>    ";
    echo "welcome ".$_SESSION['username']."<a href='logout'>Logout</a><br>";
} 
