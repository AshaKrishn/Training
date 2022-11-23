<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class LoginForm
{
    public function display()
    {
?>
        <!DOCTYPE html>
		<html>
		<head>
		<title>Login Form</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
		<div class="header">
			<h2>Login</h2>
		</div>
			
		<form method="post" action="validateRegistration" method="post">
			<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="">
			</div>
			<div class="input-group">
			<label>Password</label>
			<input type="text" name="Password" value="">
			</div>

            <p>
				New to the store? <a href="register">Register here</a>
			</p>
		</form>
		</body>
		</html>

<?php
    }
}
?>
