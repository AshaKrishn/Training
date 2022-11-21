<?php
require_once realpath('../Data/Registration.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user = array();
    if (!empty($_POST['firstname'])) {
        $user['firstname'] = sanitize($_POST['firstname']);
    } else {
        echo errorMessage('firstname');
        return;
    }

    if (!empty($_POST['lastname'])) {
        $user['lastname'] = sanitize($_POST['lastname']);
    } 

    if (!empty($_POST['username'])) {
        $user['username'] = sanitize($_POST['username']);
    } else {
        echo errorMessage('username');
        return;
    }

    
    $user['password'] = sanitize($_POST['password_1']);
    //$user['confirmpassword'] = sanitize($_POST['password_2']);
    $user['email'] = sanitize($_POST['email']);
    $user['phoneno'] = sanitize($_POST['phoneno']);
    $user['gender'] = sanitize($_POST['gender']);
    
    //echo "<pre>"; print_r($_POST);
    $newRegistration = new Registration();
    $newRegistration->registerUser($user);
   
}

function sanitize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;    
}

function errorMessage($errMsg)
{

  switch ($errMsg){
      case 'firstname' : return "First name cannot be empty";
      case 'username' : return "User name cannot be empty";
  }
}