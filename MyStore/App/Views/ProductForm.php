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
		<style type="text/css"><?php include 'style.css'; ?></style>
		<title>Add Product</title>
		</head>
		<body>
		
		<div class="header">
			<h2>Add Product</h2>
		</div>
		<form method="post" action="validateAddProduct" method="post">
			<div class="input-group">
			<label>Name </label>
			<input type="text" name="name" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Make</label>
			<input type="text" name="make" value="<?php echo (isset($_POST['make'])) ? $_POST['make'] : ''; ?>">
			</div>
			<div class="input-group">
			<label>Description</label>
			<textarea name="description" rows="5" cols="50"><?php echo (isset($_POST['description'])) ? $_POST['description'] : ''; ?></textarea>
			</div>
			<div class="input-group">
			<label>Price</label>
			<input type="text" name="price" value="<?php echo (isset($_POST['price'])) ? $_POST['price'] : ''; ?>">
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


    public function viewProducts($products)
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<style type="text/css"><?php include 'style.css'; ?></style>
		<title>Show Products</title>
		</head>
		<body>
		<div class="header">
			<h2>Products</h2>
		</div>
		<div class="list-header">
			<ul>
  			<li>Name</li>
  			<li>Make</li>
  			<li>Description</li>
			<li>Price</li>
			<li>Quantity</li>
			</ul> 	
		 </div>
			
		<form method="post" action="manageCart" method="post">
		<?php
                if (!$products) {
                    echo "No Products to list..!";
                } else {
                    foreach ($products as $product) {
                        ?>
					<div class="list-content">
						<ul>
						<li><?php echo $product['name']; ?></li>
						<li><?php echo $product['make']; ?></li>
						<li><?php echo $product['description']; ?></li>
						<li><?php echo $product['currency'].' '. $product['price']; ?></li>
						<!--<li><input type="text" name="quantity[<?php echo $product['id'] ?>]" value=""></li> -->
						<li><select name="quantity[<?php echo $product['id'] ?>]">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							</select>
						</li>
						<li><button type="submit" name = "productId" value = "<?php echo $product['id'] ?>" class="button" >Add to cart</button></li>
						<?php if ($_SESSION['username'] == 'admin') {?>
							<li><button type="submit" name = "editId" value = "<?php echo $product['id'] ?>" class="button" >Edit</button></li>
						<?php } ?>
						</ul>
					</div>
				<?php
                    }
                }
        ?>	
			
		</form>
		</body>
		</html>
<?php
    $str = ob_get_contents();
        return $str;
    }

    public function editProduct($product)
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
		<style type="text/css"><?php include 'style.css'; ?></style>
		<title>Edit Product</title>
		</head>
		<body>
		
		<div class="header">
			<h2>Edit Product</h2>
		</div>
		<form method="post" action="manageProduct" method="post">
			<div class="input-group">
			<input type="hidden" name=id value="<?php echo $product['id']; ?>">
			<label>Name </label>
			<input type="text" name="name" value="<?php echo $product['name']; ?>" readonly>
			</div>
			<div class="input-group">
			<label>Make</label>
			<input type="text" name="make" value="<?php echo $product['make']; ?>" readonly>
			</div>
			<div class="input-group">
			<label>Description</label>
			<textarea name="description" rows="5" cols="50"><?php echo (isset($_POST['description'])) ? $_POST['description'] : $product['description']; ?></textarea>
			</div>
			<div class="input-group">
			<label>Price</label>
			<input type="text" name="price" value="<?php echo (isset($_POST['price'])) ? $_POST['price'] : $product['price']; ?>">
			</div>
			<div class="input-group">
			<label>Currency</label>
			<select name="currency">
			<option value="INR" <?php if ($product['currency'] == 'INR') {?> selected <?php }?> >INR</option>
			<option value="USD"<?php if ($product['currency'] == 'USD') {?> selected <?php }?> >USD</option>
			<option value="GBP"<?php if ($product['currency'] == 'GBP') {?> selected <?php }?> >GBP</option>
			</select>
			</div>
			<div class="input-group">
			<button type="submit" class="button" name = "action" value="update" >Update</button>
			<button type="submit" class="button" name = "action" value="delete">Delete</button>
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