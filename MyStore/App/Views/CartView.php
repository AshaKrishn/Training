<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class CartView
{
    public $userOrder = array();
    public function display($cartItems)
    {
		ob_start();
    ?>
		<!DOCTYPE html>
		<html>
		<head>
        <style type="text/css"><?php include 'style.css'; ?>
        </style>
		<title>Your Cart</title>
    
		</head>
		<body>
		
		<div class="header">
			<h2>Items in your cart</h2>
		</div>
		<div class="list-header">
			<ul>
            <li>Select</li>    
  			<li>Name</li>
  			<li>Make</li>
  			<li>Price</li>
			<li>Quantity</li>
            <li>Total</li>
			</ul> 	
		 </div>
			
		<form method="post" action="updateCart" method="post">
		<?php 
			if(!$cartItems) {
				echo "No Items in your cart..!";
			} else {
				foreach ($cartItems as $key => $item) {
                ?>
					<div class="list-content">
						<ul>
                        <li><input type="checkbox" name="<?php echo $key ?>[id]" value="<?php echo $item['cart_id'] ?>"></li>
						<li><input type="hidden" name="<?php echo $key ?>[name]" value="<?php echo $item['name'] ?>"><?php echo $item['name']; ?></li>
						<li><input type="hidden" name="<?php echo $key ?>[make]" value="<?php echo $item['make'] ?>"><?php echo $item['make']; ?></li>
						<li><input type="hidden" name="<?php echo $key ?>[quantity]" value="<?php echo $item['quantity'] ?>"><?php echo $item['quantity']; ?></li>
                        <li><input type="hidden" name="<?php echo $key ?>[currency]" value="<?php echo $item['currency'] ?>"><?php echo $item['currency']; ?></li>
                        <li><input type="hidden" name="<?php echo $key ?>[price]" value="<?php echo $item['price'] ?>"><?php echo $item['price']; ?></li>
                        <li><input type="hidden" name="<?php echo $key ?>[total]" value="<?php echo ($item['quantity']*$item['price']); ?>"><?php echo ($item['quantity']*$item['price']); ?></li>
						</ul>
					</div>
				<?php
				}
			}
		?>	
		<button type="submit" class="button" name="action" value="buy">Buy Now</button>
        <button type="submit" class="button" name="action" value ="remove">Remove from cart</button>
		</form>
		</body>
		</html>
<?php
    $str = ob_get_contents();
	return $str;
    }

    public function viewShippingAddresses($orderItems,$userAddresses)
    {
         
		ob_start();
    ?>
		<!DOCTYPE html>
		<html>
		<head>
        <style type="text/css"><?php include 'style.css'; ?>
        </style>
		<title>Address</title>
    
		</head>
		<body>
		<p>
			<a href="index"><< Back to Home >></a>
		</p>
		<div class="header">
			<h2>Select the address to which these items need to be shipped</h2>
		</div>
				
		<form method="post" action="placeOrder" method="post">
        <?php 

            if(!$orderItems) {
                echo "No Items selected..!";
            } else {
                foreach ($orderItems as $key => $item) {
        ?>
                    <div class="list-cart-content">
                        <label>Item # <?php echo ($key+1); ?></label>
                        <input type="hidden" name="id[]" value="<?php echo $item['id'] ?>">
                        <ul>
                        <li><?php echo $item['name']; ?></li>
                        <li><?php echo $item['make']; ?></li>
                        <li><?php echo $item['currency']; ?></li>
                        <li><?php echo $item['price']; ?></li>
                        <li><?php echo $item['quantity']; ?></li>
                        <li><?php echo ($item['quantity']*$item['price']); ?></li>
                        </ul>
                    </div>
        <?php
                }
            }
			if(!$userAddresses) {
				echo "Please add shipping address before proceeding..!";
			} else {
                echo "<label>Addresses</label>";
				foreach ($userAddresses as $key => $userAddress) {
        ?>
					<div class="list-content">
                        <ul>
                            <li><input type="radio" name="address" value="<?php echo $userAddress['id'] ?>" 
                                <?php if ($userAddress['default_address']=='yes') { ?> checked <?php } ?>> </li>
                            <li><?php echo $userAddress['address']; ?></li>
                            <li><?php echo $userAddress['city']; ?></li>
                            <li><?php echo $userAddress['state']; ?></li>
                            <li><?php echo $userAddress['country']; ?></li>
                            <li><?php echo $userAddress['postal_code']; ?></li>
                            
                        </ul>
			        </div>
		<?php
				}
			}
		?>	
		<button type="submit" class="button" >Ship to this address</button>
		</form>
		</body>
		</html>
<?php
    $str = ob_get_contents();
	return $str;
    }
}