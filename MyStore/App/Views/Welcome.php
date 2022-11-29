<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class Welcome 
{
    public function display()
    {

?>
<!DOCTYPE html>
	<html>
		<head>
        <style type="text/css"><?php include 'style.css'; ?></style>
		<title>My Store</title>
		</head>
		<body>
		<p class='header'>Welcome to My Store !!<p>
        <div class='home-page'>
	    <a href="login">Click here to login</a>
		<a href="register">Click here to register</a>
        </div>
        </body>
    </html>
       
<?php
    }
}
?>

