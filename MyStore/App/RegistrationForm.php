<?php
namespace StoreApp;

ini_set('display_errors', 1);
use StoreApp\Controllers\Register;

/*
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $register = new Register();
    if ($register->validateRegistration($_POST)) {
        echo "<br>Successfully registered...!!</br>";
        exit();
    } else {
        echo "Please try again ..!!</br>";
    }
}
*/
class RegistrationForm 
{
	public function display()
	{
    ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>Registration Form</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
		<div class="header">
			<h2>Register</h2>
		</div>
			
		<form method="post" action="validateRegistration" method="post">
			<div class="input-group">
			<label>Firstname</label>
			<input type="text" name="firstname">
			</div>
			<div class="input-group">
			<label>Lastname</label>
			<input type="text" name="lastname">
			</div>
			<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
			</div>
			<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
			</div>
			<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
			</div>
			<div class="input-group">
			<label>Email</label>
			<input type="email" name="email">
			</div>
			<div class="input-group">
			<label>Phone No</label>
			<input type="text" name="phoneno">
			</div>
			<div class="input-group">
			<label>Gender</label>
			<input type="radio" name="gender" value="male" checked> Male
			<input type="radio" name="gender" value="female"> Female
			<input type="radio" name="gender" value="others"> Others
			</div>
			<div class="input-group">
			<button type="submit" class="button" >Register Me</button>
			</div>
			<p>
				Already a member? <a href="login.php">Login in</a>
			</p>
		</form>
		</body>
		</html>
<?php
	}
}
?>