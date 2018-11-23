<?php

class User extends AbstractUser {

    /**
     *
     * @var Model
     */
    private $model;
    private $data;

    public function __construct(\Database $db) {
        parent::__construct($db);
        $this->model = new Model($db, 'users');
        session_start();
    }

    public function delete() {
        
    }

    public function isLoggedIn() {
        /*  $_SESSION['logged_in'] ?? false; //Kitas variantas kaip parasyt be ??
          if (isset($_SESSION['logged_in'])) {
          return $_SESSION['logged_in'];
          } else {
          return false;
          }
         */
        $previously_logged_in = $_SESSION['logged_in'] ?? false;
        if ($this->is_logged_in || $previously_logged_in) {
            return true;
        }
    }

    public function login($email, $password) {
        $user = $this->model->load($email);
        if ($user) {
            if ($user['password'] == $password) {
                $this->data = $user;
                $this->is_logged_in = true;
                $_SESSION['user'] = $user;
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

    public function register($email, $password, $full_name) {
        //kai submitinsiu forma indexe kad issaugotu i db.txt info
        $data = [
            'password' => $password,
            'full_name' => $full_name
        ];
        $this->model->insertOrUpdate($email, $data);
    }

}
