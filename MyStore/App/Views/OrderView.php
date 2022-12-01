<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class OrderView
{
    public function display($orderItems)
    {
        ob_start();
        ?>
		<!DOCTYPE html>
		<html>
		<head>
        <style type="text/css"><?php include 'style.css'; ?>
        </style>
		<title>My Orders</title>
    
		</head>
		<body>
		<form method="post" action="manageOrders" method="post">
		<?php
            if (!$orderItems) {
                echo "No Orders Yet..!";
                ?>
				<button type="submit" class="button" name="action" value="productLists">Start Shopping</button>
		<?php
            } else {
                ?>
		<div class="header">
			<h2>Ordered Items</h2>
		</div>

		<?php

                foreach ($orderItems as $key => $item) {
        ?>
					<div class="list-content">
                    
                    <label><b>Order No # <?php echo $item['order_id']; ?></b></label>
                        
        <?php
                    foreach ($item['products'] as $pKey=>$product) {
        ?>              <ul>
                        <label>Item # <?php echo ($pKey+1); ?></label>
                        <li><?php echo $product['name'].'---'.$product['make']; ?></li>
						<li><?php echo $product['currency'].' '. $product['price'].' '; ?></li>
						<li><?php echo '('.$product['order_quantity'].' Qty) '. 'Total---'.$product['currency'].' '.($product['price']*$product['order_quantity']); ?></li>
                        <li><button type="submit" class="button" name="remove" value="<?php echo $product['order_details_id'] ?>">Remove</button></li>
                        <input type="hidden" name="order_id" value="<?php echo $product['order_id'] ?>">
                        </ul>
        <?php
                    }
        ?>
                       <ul>
                        <label>Shipping Address</br></label> 
                        <table class='tbl-list'>
                        <tr>
                            <th><label><?php echo $item['address'].'<br>'.$item['city'].'<br>'.$item['state'].'<br>'.$item['country'].
                            '<br>'.$item['postal_code']; ?></label></th>
                            </tr>
                        </table> 
                       </ul>
                       <b>============================================================================================================================</b>
                    </div>

                   
		<?php
                }
        ?>
		
		<?php
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