<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserRepository {

    protected $db;
    protected $model;

    public function __construct(MysqlDatabase $db) {
        $this->db = $db;
        $this->model = new ModelUsers($db, 'users');
    }

    public function add(User $user) {
        $this->model->insert(
                $user->getEmail(), $user->getData()
        );
    }

    public function load($email) {
        $data = $this->model->load($email);
        if ($data) {
            return new User($email, $data);
        } else {
            return null;
        }
        return $data ? new User($email, $data) : null;
    }

    public function loadAll() {
        $user = [];
        $data_arr = $this->model->loadAll();
        foreach ($data_arr as $user_data) {
            $email = $user_data['email'];
            $users[$email] = new User($email, $user_data);
        }
        // Useriu array
        // Arrayjaus elementas - User klases instancija (objektas)
        return $users;
    }

    public function update(User $user) {
        $data = [];


        $this->model->insertOrUpdate($user->getEmail(), $user->getData());
    }

    public function delete(User $user) {
        $this->model->delete($user->getEmail());
    }

    public function deleteAll() {
        $this->model->deleteAll();
    }

}
