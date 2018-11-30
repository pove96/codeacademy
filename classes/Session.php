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
    /**
     * Loads user from UserRepository by its email and checks If user
     * entered password is equal to a password that has been saved - user logs in
     * 
     * @param type $email
     * @param type $password
     * @return boolean
     */
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
    /**
     * If user is logged in  - destroys the session and deletes cookie.
     */
    public function logout() {
        if ($this->isLoggedIn()) {
            $_SESSION = [];
            session_destroy();
            setcookie(session_name(), '', time() - 36000);
        }

        $this->is_logged_in = false;
    }
    /**
     * 
     * Function to register a new user by its email, password and data
     * Checks if user is not loaded, then creates a new user, sets a password,
     * add that user to user repository and returns true as a sign of successful
     * registration, if not return false
     * 
     * @param type $email
     * @param type $password
     * @param type $data
     */
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
    /*
     * Returns successful registration
     */
    public function isRegistrationSuccessful() {
        return $this->register_success;
    }
    /**
     * Checks if user is logged in, if so, returns current user.
     * 
     * @return $current_user
     */
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $current_user = $this->user_repo->load($_SESSION['email']);
            return $current_user;
        } 
    } 

}