<?php
/**
 * 
 * UserRepository class
 * 
 * This class stores all users
 * 
 */
class UserRepository {

    /**
     *  Mysql Database Instance
     * @var type MysqlDatabase
     */
    protected $db;

    /**
     *  Model class Injection
     * @var Model
     */
    protected $model;
    // Construct for UserRepository
    public function __construct(MysqlDatabase $db) {
        $this->db = $db;
        $this->model = new ModelUsers($db, 'users');
    }
    // Function to add user
    public function add(User $user) {
        $this->model->insert(
                $user->getEmail(), $user->getData()
        );
    }
    // Function to load user by email and return new user
    public function load($email) {
        $data = $this->model->load($email);
        if ($data) {
            return new User($email, $data);
        } else {
            return null;
        }
        return $data ? new User($email, $data) : null;
    }
    // Function to load all users
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
