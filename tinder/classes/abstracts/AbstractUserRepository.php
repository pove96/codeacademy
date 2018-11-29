<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author CodeAcademy
 */
abstract class AbstractUserRepository {

    /**
     * Database class instance
     * @var Datbase
     */
    protected $db;

    /**
     * Model instance of the user table(model)
     * @var Model
     */
    protected $model;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->model = new Model($db, 'users');
    }

    abstract public function add(User $user);

    /**
     * #1 Loads user data from the database via model
     * #2 Creates a User instance from that data
     * #3 Returns that User instance
     * 
     * @param string $email
     * @return AbstractUser
     */
    abstract public function load($email);

    abstract public function update(User $user);

    abstract public function loadAll();

    abstract public function delete($email);

    abstract public function deleteAll();
}
