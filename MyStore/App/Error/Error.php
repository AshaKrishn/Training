<?php

namespace StoreApp\Error;

class Error
{
    public function errorMessage($errMsg)
    {
        switch ($errMsg) {
            case 'firstname': echo "<br>First name cannot be empty..!!</br>";
                break;
            case 'username': echo "<br>User name cannot be empty..!!</br>";
                break;
            case 'password_1': echo "<br>Password cannot be empty..!!</br>";
                break;
            case 'password_2': echo "<br>Confirm password cannot be empty..!!</br>";
                break;
            case 'phoneno': echo "<br>Phone number cannot be empty..!!</br>";
                break;
            case 'email': echo "<br>Email required..!!</br>";
                break;
            case 'address': echo "<br>Address required..!!</br>";
                break;
            case 'city': echo "<br>City required..!!</br>";
                break;
            case 'state': echo "<br>State required..!!</br>";
                break;
            case 'country': echo "<br>Country required..!!</br>";
                break;
            case 'pincode': echo "<br>Pincode required..!!</br>";
                break;
            case 'password_mismatch': echo "<br>Confirm password is not matching with the password entered..!!</br>";
                break;
            case 'phone_not_number': echo "<br>Please enter only numeric value for phone number..!!</br>";
                break;
            case 'phone_length_mismatch': echo "<br>The length of phone number must be 10 digits..!!</br>";
                break;
            case 'username_exists': echo "<br>This username exists.Please choose a different one..!!</br>";
                break;
            case 'incorrect_password': echo "<br>Password not correct.Please try again..!!</br>";
                break;  
            case 'username_not_found': echo "<br>This username doesnot exists.Please try again..!!</br>";
                break;
            case 'logout': echo "<br>Error while logging out.Please try again..!!</br>";
                break; 
            case 'product_name': echo "<br>Please specify the product name ..!!</br>";
                break; 
            case 'product_make': echo "<br>Please specify the make..!!</br>";
                break; 
            case 'product_price': echo "<br>Product price cannot be empty..!!</br>";
                break; 
            case 'product_price_format': echo "<br>Please enter price in correct format..!!</br>";
                break; 
            case 'no_address_found': echo "<br>Please add address before ordering products..!!</br>";
                break; 
            case 'cart_add_error': echo "<br>Could not add to the cart.Please try again..!!</br>";
                break;   
            case 'no_item_selected': echo "<br>Please select an item..!!</br>";
                break;    
            case 'user_not_found': echo "<br>User not found..!!</br>";
                break; 
            case 'unauthorised_access': echo "<br>Unauthorised Login.Please relogin.!!</br>";
                break;
            case 'checkout': echo "<br>Error while checking out..!</br>";
                break;    
                
        }
    }
}
