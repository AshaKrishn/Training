<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
use StoreApp\Controllers\Register;

class RegistrationForm
{
    public function display()
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>Registration Form</title>
		<style type="text/css"><?php include 'style.css'; ?></style>
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Register</h2>
		</div>
		<form method="post" class = "input-form" action="validateRegistration" method="post">
		
			<div class="input-group">
			<label>Firstname</label>
			<input type="text" name="firstname" value="<?php echo (isset($_POST['firstname'])) ? $_POST['firstname'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Lastname</label>
			<input type="text" name="lastname" value="<?php echo (isset($_POST['lastname'])) ? $_POST['lastname'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo (isset($_POST['username'])) ? $_POST['username'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1"  value="<?php echo (isset($_POST['password_1'])) ? $_POST['password_1'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2"  value="<?php echo (isset($_POST['password_2'])) ? $_POST['password_2'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Email</label>
			<input type="email" name="email"  value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Phone No</label>
			<input type="text" name="phoneno" value="<?php echo (isset($_POST['phoneno'])) ? $_POST['phoneno'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Gender</label>
			<input type="radio" name="gender" value="male" checked> Male
			<input type="radio" name="gender" value="female"> Female
			<input type="radio" name="gender" value="others"> Others
			</div>
			<div class="input-group">
			<label>Address</label>
			<textarea name="address" rows="5" cols="50"><?php echo (isset($_POST['address'])) ? $_POST['address'] : ''; ?></textarea>
			</div>
			<div class="input-group">
			<label>Address Type</label>
			<select name="address_type">
			<option value="billing">Billing</option>
			<option value="shipping">Shipping</option>
			</select>
			</div>
			<div class="input-group">
			<label>Default Address</label>
			<input type="radio" name="default" value="yes" checked> Yes
			<input type="radio" name="default" value="no"> No
			</div>
			<div class="input-group">
			<label>City</label>
			<input type="text" name="city" value="<?php echo (isset($_POST['city'])) ? $_POST['city'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>State</label>
			<input type="text" name="state" value="<?php echo (isset($_POST['state'])) ? $_POST['state'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Country</label>
			<input type="text" name="country" value="<?php echo (isset($_POST['country'])) ? $_POST['country'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Pincode</label>
			<input type="text" name="pincode" value="<?php echo (isset($_POST['pincode'])) ? $_POST['pincode'] : ''; ?>">
			</div>
			<div class="input-group">
			<button type="submit" class="button" >Register Me</button>
			</div>
			<p>
				Already a member? <a href="login">Login in</a>
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