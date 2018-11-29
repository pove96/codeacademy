<?php

class Session {

    /**
     *
     * @var UserRepository
     */
    private $user_repo;
    private $is_logged_in;
    private $register_success;

    public function __construct(UserRepository $repo) {
        $this->user_repo = $repo;
        session_start();
        $this->is_logged_in = $_SESSION['logged_in'] ?? false;
    }

    public function isLoggedIn() {
        return $this->is_logged_in;
    }

    public function login($email, $password) {
        $user = $this->user_repo->load($email);
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
        if (!$this->user_repo->load($email)) {
            $new_user = new User($email, $data);
            $new_user->setPassword($password);
            $this->user_repo->add($new_user);
            $this->register_success = true;
        } else {
            $this->register_success = false;
        }
    }

    public function isRegistrationSuccessful() {
        return $this->register_success;
    }

    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $current_user = $this->user_repo->load($_SESSION['email']);
            return $current_user;
        } 
    } 

}