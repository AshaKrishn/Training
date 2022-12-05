<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Registration;
use StoreApp\Controllers\BaseController;
use StoreApp\Views\RegistrationForm;

ini_set('display_errors', 1);

class RegisterController extends BaseController
{
    public $registration;
    public $registrationForm;

    public function __construct()
    {
        parent::__construct();
        $this->registration = new Registration();
        $this->registrationForm = new RegistrationForm();
    }
    public function validate()
    {
        if (empty($_POST)) {
            return $this->registrationForm->display();
        }
        if (!$user = $this->helper->validateUserInput($_POST)) {
            return $this->registrationForm->display();
        }
        $this->add($user);
    }

    public function add($user)
    {
        if ($this->dbHelper->checkUsername($user['username'])) {
            $this->helper->printError('username_exists');
            return $this->registrationForm->display();
        }
        if ($user['id'] = $this->registration->registerUser($user)) {
            echo "Successfully registered..!";
            ($this->helper)->setUserSession($user);
            ($this->helper)->redirect('login');
        } else {
            echo "Error while Registering";
            return $this->registrationForm->display();
        }
    }
}
