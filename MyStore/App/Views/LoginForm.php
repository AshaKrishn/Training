<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class LoginForm
{
    public function display()
    {
		ob_start();
        ?>
        <!DOCTYPE html>
		<html>
		<head>
		<title>Login Form</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Login</h2>
		</div>
			
		<form method="post" action="validateLogin" method="post">
			<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="">
			</div>
			<div class="input-group">
			<label>Password</label>
			<input type="password" name="password" value="">
			</div>
			<div class="input-group">
			<button type="submit" class="button" >Login</button>
			</div>
            <p>
				New to the store? <a href="register">Register here</a>
			</p>
		</form>
		</body>
		</html>

<?php
	$str = ob_get_contents();
	return $str;
    }
}
?>
