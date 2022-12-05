<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Registration;
use StoreApp\Controllers\BaseController;
use StoreApp\Views\LoginForm;
use StoreApp\Views\UserProfileForm;

ini_set('display_errors', 1);

class ProfileController extends BaseController
{
    public $loginForm;
    public $userProfileForm;
    public $registration;

    public function __construct()
    {
        parent::__construct();
        $this->loginForm = new LoginForm();
        $this->userProfileForm = new UserProfileForm();
        $this->registration = new Registration();
    }
    public function get()
    {
        if (!isset($_SESSION['userid'])) {
            $this->loginForm->display();
        }
        $userDetails = $this->dbHelper->getUserDetails($_SESSION['userid']);
        if (!$userDetails) {
            $this->helper->printError('user_not_found');
            $this->helper->redirect('login');
        }
        $userAddresses['addresses'] = $this->dbHelper->getUserAddresses($_SESSION['userid']);
        if (!$userAddresses) {
            $this->helper->printError('no_address_found');
            $this->loginForm->display();
        }
        $userDetails = array_merge($userDetails, $userAddresses);
        return $this->userProfileForm->display($userDetails);
    }

    public function update()
    {
        if (!$_POST) {
            return $this->get();
        }
        if ($_POST['user']['userid'] != $_SESSION['userid']) {
            $this->helper->printError('unauthorised_access');
            $this->helper->redirect('login');
        }
        if (isset($_POST['remove_address'])) {
            $this->registration->deleteUserAddress($_POST['remove_address']);
            $this->helper->redirect('profile');
        }

        if (isset($_POST['action']) && $_POST['action'] == 'add_address') {
            $this->helper->redirect('address');
        }

        if (!$user = $this->helper->validateUserInput($_POST['user'])) {
            return $this->get();
        }
        $this->registration->updateUserDetails($user);
        if (isset($_POST['address'])) {
            foreach ($_POST['address'] as $address) {
                if (!$userAddress = $this->helper->validateUserInput($address)) {
                    return $this->get();
                }
                $this->registration->updateUserAddress($userAddress);
            }
        }
        return $this->get();
    }

    public function updatePassword()
    {
        if (!$_POST) {
            return $this->get();
        }
        if (!isset($_SESSION['userid'])) {
            $this->helper->printError('unauthorised_access');
            $this->helper->redirect('login');
        }
        $_POST['userid'] = $_SESSION['userid'];
        if (!($user = $this->helper->validateUserInput($_POST))) {
            return $this->userProfileForm->passwordChangeForm();
        }
        if (!($dbuser = $this->dbHelper->checkUsername($_SESSION['username']))) {
            $this->helper->printError('user_not_found');
            $this->helper->redirect('login');
        }
        if (!password_verify($user['password_old'], $dbuser['password'])) {
            $this->helper->printError('incorrect_password');
            return $this->userProfileForm->passwordChangeForm();
        }
        $this->registration->updateUserPassword($user);
        return $this->get();
    }

    public function addAddress()
    {
        if (!$_POST) {
            return $this->get();
        }
        if (!($address = $this->helper->validateUserInput($_POST))) {
            return $this->userProfileForm->addAddressForm();
        }
        $this->registration->registerUserAddresses($_SESSION['userid'], $address);
        $this->helper->redirect('profile');
    }
}
