<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class CartView
{
    public function display($cartItems)
    {
		ob_start();
    ?>
		<!DOCTYPE html>
		<html>
		<head>
		<title>Your Cart</title>
		<style>
			body {
				background-color: bisque;
			}
			.list-header, .list-header ul {
				list-style-type: none;
				font-family:monospace; 
				font-size: 14px; 
				font-display: block;
				
			}
			.list-content, .list-content ul {
				list-style-type: none;
				font-family:monospace; 
				font-size: 14px; 
				font-display: block;
				
			}
			.list-header ul li{
				display:inline;
				padding: 14px 16px;
			}
			.list-content ul li{
				display:inline;
				padding: 14px 16px;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="Style.css">
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Items in your cart</h2>
		</div>
		<div class="list-header">
			<ul>
  			<li>Name</li>
  			<li>Make</li>
  			<li>Price</li>
			<li>Quantity</li>
            <li>Total</li>
			</ul> 	
		 </div>
			
		<form method="post" action="addToCart" method="post">
		<?php 
			if(!$cartItems) {
				echo "No Items in your cart..!";
			} else {
				foreach ($cartItems as $item) {
				?>
					<div class="list-content">
						<ul>
                        <li><input type="checkbox" name="order[<?php echo $item['id'] ?>]" value="Boat"></li>
						<li><?php echo $item['name']; ?></li>
						<li><?php echo $item['make']; ?></li>
						<li><?php echo $item['currency'].' '. $item['price']; ?></li>
                        <li><?php echo $item['quantity']; ?></li>
                        <li><?php echo ($item['quantity']*$item['price']); ?></li>
						<li><button type="submit" name = "" value = "<?php echo $item['id'] ?>" class="button" >Buy Now</button></li>
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
}