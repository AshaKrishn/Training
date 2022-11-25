<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
use StoreApp\Controllers\Register;

class ProductForm
{
    public function addProduct()
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>Add Product</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Add Product</h2>
		</div>
		<form method="post" action="validateAddProduct" method="post">
			<div class="input-group">
			<label>Name </label>
			<input type="text" name="name" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : 'clarks'; ?>">
			</div>
			<div class="input-group">
			<label>Make</label>
			<input type="text" name="make" value="<?php echo (isset($_POST['make'])) ? $_POST['make'] : 'make'; ?>">
			</div>
			<div class="input-group">
			<label>Description</label>
			<textarea name="description" rows="5" cols="50"><?php echo (isset($_POST['description'])) ? $_POST['description'] : ''; ?></textarea>
			</div>
			<div class="input-group">
			<label>Price</label>
			<input type="text" name="price" value="<?php echo (isset($_POST['price'])) ? $_POST['price'] : '0'; ?>">
			</div>
			<div class="input-group">
			<label>Currency</label>
			<select name="currency">
			<option value="INR">INR</option>
			<option value="USD">USD</option>
			<option value="GBP">GBP</option>
			</select>
			</div>
			<div class="input-group">
			<button type="submit" class="button" >ADD</button>
			</div>
			
		</form>
		</body>
		</html>
<?php
    	$str = ob_get_contents();
        return $str;
    }


	public function showProducts()
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>Show Products</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Add Product</h2>
		</div>
		<form method="post" action="" method="post">
			<div class="input-group">
			<label>Name </label>
			<input type="text" name="name" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : 'clarks'; ?>">
			</div>
			<div class="input-group">
			<label>Make</label>
			<input type="text" name="make" value="<?php echo (isset($_POST['make'])) ? $_POST['make'] : 'make'; ?>">
			</div>
			<div class="input-group">
			<label>Description</label>
			<textarea name="description" rows="5" cols="50"><?php echo (isset($_POST['description'])) ? $_POST['description'] : ''; ?></textarea>
			</div>
			<div class="input-group">
			<label>Price</label>
			<input type="text" name="price" value="<?php echo (isset($_POST['price'])) ? $_POST['price'] : '0'; ?>">
			</div>
			<div class="input-group">
			<label>Currency</label>
			<select name="currency">
			<option value="INR">INR</option>
			<option value="USD">USD</option>
			<option value="GBP">GBP</option>
			</select>
			</div>
			<div class="input-group">
			<button type="submit" class="button" >ADD</button>
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