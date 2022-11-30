<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
use StoreApp\Controllers\Register;

class UserProfileForm
{
    public function display($user)
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>User Profile</title>
		<style type="text/css"><?php include 'style.css'; ?></style>
		</head>
		<body>
		
		<div class="header">
			<h2>My Profile</h2>
		</div>
		<form method="post" class = "input-form" action="updateProfile" method="post">
            <input type="hidden" name="user[userid]" value="<?php echo $user['id'] ?>">
			<div class="input-group">
			<label>Firstname</label>
			<input type="text" name="user[firstname]" value="<?php echo $user['first_name'] ; ?>">
			</div>
			<div class="input-group">
			<label>Lastname</label>
			<input type="text" name="user[lastname]" value="<?php echo $user['last_name'] ; ?>">
			</div>
			<div class="input-group">
			<label>Email</label>
			<input type="email" name="user[email]" value="<?php echo $user['email'] ; ?>">
			</div>
			<div class="input-group">
			<label>Phone No</label>
			<input type="text" name="user[phoneno]" value="<?php echo $user['phone_no'] ; ?>">
			</div>
            
			<div class="input-group">
			<label>Gender</label>
			<input type="radio" name="user[gender]" value="male" <?php if($user['gender'] == 'male') { ?> checked <?php } ?> > Male
			<input type="radio" name="user[gender]" value="female" <?php if($user['gender'] == 'female') { ?> checked <?php } ?>> Female
			<input type="radio" name="user[gender]" value="others" <?php if($user['gender'] == 'others') { ?> checked <?php } ?>> Others
			</div>
    <?php
            foreach ($user['addresses'] as $key=>$address) {
    ?>
            <p>
            <label>Address # <?php echo ($key+1); ?> ===================================================</label>
            </p>
            <input type="hidden" name="address[<?php echo $key ?>][id]" value="<?php echo $address['id'] ?>">
			<div class="input-group">
			<label>Address</label>
			<textarea name="address[<?php echo $key ?>][address]" value="<?php echo $address['address'] ?>" rows="5" cols="50"><?php echo (isset($address['address'])) ? $address['address'] : ''; ?></textarea>
			
            </div>
			<div class="input-group">
			<label>Address Type</label>
			<select name="address[<?php echo $key ?>][address_type]">
			<option value="billing" <?php if ($address['address_type'] == 'billing') { ?> selected <?php } ?> >Billing</option>
			<option value="shipping" <?php if ($address['address_type'] == 'shipping') { ?> selected <?php } ?>>Shipping</option>
			</select>
            
			</div>
			<div class="input-group">
			<label>Default Address</label>
			<input type="radio" name="address[<?php echo $key ?>][default]" value="yes" <?php if ($address['default_address'] == 'yes') { ?> checked <?php } ?> > Yes
			<input type="radio" name="address[<?php echo $key ?>][default]" value="no" <?php if ($address['default_address'] == 'no') { ?> checked <?php } ?> > No
			<button type="submit" class="button" name="remove_address" value="<?php echo $address['id'] ?>">Remove Address</button>
            </div>
			<div class="input-group">
			<label>City</label>
			<input type="text" name="address[<?php echo $key ?>][city]" value="<?php echo (isset($address['city'])) ? $address['city'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>State</label>
			<input type="text" name="address[<?php echo $key ?>][state]" value="<?php echo (isset($address['state'])) ? $address['state'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Country</label>
			<input type="text" name="address[<?php echo $key ?>][country]" value="<?php echo (isset($address['country'])) ? $address['country'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Pincode</label>
			<input type="text" name="address[<?php echo $key ?>][pincode]" value="<?php echo (isset($address['postal_code'])) ? $address['postal_code'] : ''; ?>">
			</div>
            
    <?php
            }   
    ?>
			<div class="input-group">
			<button type="submit" class="button" name="action" value="update">update profile</button>
			<button type="submit" class="button" name="action" value="add_address">Add New Address</button>
			</div>
            <p>
			<a href="changePassword">Change Password</a>
		    </p>
		</form>

		</body>
		</html>
<?php
        $str = ob_get_contents();
        return $str;
    }

    public function passwordChangeForm()
    {
        ob_start();
?>
        <!DOCTYPE html>
		<html>
		<head>
		<title>Change Password</title>
		<style type="text/css"><?php include 'style.css'; ?></style>
		</head>
		<body>
		
		<div class="header">
			<h2>Change Password</h2>
		</div>
		<form method="post" class = "input-form" action="updatePassword" method="post">
        <div class="input-group">
        <label>Old Password</label>
        <input type="password" name="password_old" value="<?php echo (isset($_POST['password_old'])) ? $_POST['password_old'] : ''; ?>">
        </div> 
        <div class="input-group">
        <label>New Password</label>
        <input type="password" name="password_1">
        </div>
        <div class="input-group">
        <label>Confirm new password</label>
        <input type="password" name="password_2">
		</div>
        <div class="input-group">
			<button type="submit" class="button">Update</button>
		</div>
        </form>
		</body>
		</html>
<?php
        $str = ob_get_contents();
        return $str;
    }

    public function addAddressForm()
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <title>Add Address</title>
        <style type="text/css"><?php include 'style.css'; ?></style>
        </head>
        <body>
        
        <div class="header">
            <h2>Add New Address</h2>
        </div>
        <form method="post" class = "input-form" action="addAddress" method="post">
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
            <button type="submit" class="button">Add Address</button>
        </div>
        </form>
        </body>
        </html>
    <?php
        $str = ob_get_contents();
        return $str;
    }

}
?>