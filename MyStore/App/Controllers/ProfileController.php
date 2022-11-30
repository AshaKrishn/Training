<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Registration;
use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;
ini_set('display_errors', 1);

class ProfileController
{
    public function getProfile() 
    {
        if (!isset($_SESSION['userid'])) {
            $this->showLoginForm();
        }
        $userDetails = (new DbHelper())->getUserDetails($_SESSION['userid']);
        if (!$userDetails) {
            (new Helper())->printError('user_not_found');
            (new Helper())->redirect('login');
        }
        $userAddresses['addresses'] = (new DbHelper())->getUserAddresses($_SESSION['userid']);
        if (!$userAddresses) {
            (new Helper())->printError('no_address_found');
            $this->showLoginForm();
        }
        
        $userDetails = array_merge($userDetails,$userAddresses);
        $page = new \StoreApp\Views\UserProfileForm();
        return $page->display($userDetails);

    }

    public function updateProfile()
    {
       
        if (!$_POST) {
            return $this->getProfile();
        }
        if ($_POST['user']['userid'] != $_SESSION['userid']) {
            (new Helper())->printError('unauthorised_access');
            (new Helper())->redirect('login');
        }
        if (isset($_POST['remove_address'])) {
            $userProfile = new Registration();
            $userProfile->deleteUserAddress($_POST['remove_address']);
            (new Helper())->redirect('profile');
        }
        
        if (isset($_POST['action']) && $_POST['action'] == 'add_address') {
            (new Helper())->redirect('address');
        }
      
        if (!$user = (new Helper())->validateUserInput($_POST['user'])) {
            return $this->getProfile();
        }
        $userProfile = new Registration();
        $userProfile->updateUserDetails($user);
        if(isset($_POST['address'])) {
            foreach ($_POST['address'] as $address) {
                if (!$userAddress = (new Helper())->validateUserInput($address)) {
                    return $this->getProfile();
                }
                $userProfile->updateUserAddress($userAddress);
            }
        }
        return $this->getProfile();
    }

    public function updatePassword() 
    {
        if (!$_POST) {
            return $this->getProfile();
        }
        if (!isset($_SESSION['userid'])) {
            (new Helper())->printError('unauthorised_access');
            (new Helper())->redirect('login');
        }
        $_POST['userid'] = $_SESSION['userid'];
        if(!($user = (new Helper())->validateUserInput($_POST))){
            $userProfile = new \StoreApp\Views\UserProfileForm();
            return $userProfile->passwordChangeForm();
        }
        if (!($dbuser = (new DbHelper())->checkUsername($_SESSION['username']))) {  
            (new Helper())->printError('user_not_found');
            (new Helper())->redirect('login');
        }   
        if (!password_verify($user['password_old'], $dbuser['password'])) {
            (new Helper())->printError('incorrect_password');
            $userProfile = new \StoreApp\Views\UserProfileForm();
            return $userProfile->passwordChangeForm();
        }
        (new Registration())->updateUserPassword($user);
        return $this->getProfile();
        
    }

    public function addAddress() 
    {
        if (!$_POST) {
            return $this->getProfile();
        }
        if(!($address = (new Helper())->validateUserInput($_POST))){
            $userProfile = new \StoreApp\Views\UserProfileForm();
            return $userProfile->addAddressForm();
        }
        (new Registration())->registerUserAddresses($_SESSION['userid'],$address);
        (new Helper())->redirect('profile');
    }

    public function showLoginForm()
    {
        $loginPage = new \StoreApp\Views\LoginForm();
        return $loginPage->display();
    }
}
