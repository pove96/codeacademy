<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserRepository {

    private $db;
    private $model;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->model = new Model($db, 'users');
    }

    public function loadAllUsers() {
        return $this->model->loadAll();
    }

    public function loadUser($email) {
        return $this->model->load($email);
    }

    public function addUser(User $user) {
        $this->model->insertOrUpdate($user->getEmail(), $user);
    }

    public function deleteUser($email) {
        $this->model->delete($email);
    }

}
