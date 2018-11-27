<?php

class Session {

    /**
     *
     * @var UserRepository
     */
    private $userrepository;
    private $is_logged_in;
    private $registrationsuccessful;

    public function __construct(UserRepository $repo) {
        $this->userrepository = $repo;
        session_start();
        $this->is_logged_in = $_SESSION['logged_in'] ?? false;
    }

    public function isLoggedIn() {
        return $this->is_logged_in;
    }

    public function login($email, $password) {
        $user = $this->userrepository->loadUser($email);
        if ($user) {
            if ($user->getPassword() == $password) {
                $this->is_logged_in = true;
                $_SESSION['email'] = $email;
                $_SESSION['logged_in'] = true;
                return true;
            }
        }
    }

    public function logout() {
        if ($this->isLoggedIn()) {
            $_SESSION = [];
            session_destroy();
            setcookie(session_name(), '', time() - 36000);
        }

        $this->is_logged_in = false;
    }

    public function register($email, $password, $data) {
        if (!$this->userrepository->loadUser($email)) {
            $newuser = new User($email, $password, $data);
            $this->userrepository->addUser($newuser);
            $this->registrationsuccessful = true;
        } else {
            $this->registrationsuccessful = false;
        }
    }

    public function registrationSuccessful() {
        return $this->registrationsuccessful;
    }

    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $current_user = $this->userrepository->loadUser($_SESSION['email']);
            return $current_user;
        } 
    } 

}
