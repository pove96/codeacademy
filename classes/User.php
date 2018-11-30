<?php

class User {

    /**
     * User email
     * @var Email
     */
    private $email;

    /**
     *  User data
     * @var Data
     */
    private $data;

    // Construct for User class with the 2 parameters
    public function __construct($email, $data) {
        $this->email = $email;
        $this->data = $data;
    }

    // Function to get users email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        return $this->email = $email;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        return $this->data = $data;
    }

    public function getFullName() {
        return $this->getDataItem('full_name');
    }

    // Function to set users full name with index full_name
    public function setFullName($full_name) {
        return $this->setDataItem('full_name', $full_name);
    }

    public function getPassword() {
        return $this->getDataItem('password');
    }

    // Function to set users password with index password
    public function setPassword($password) {
        return $this->setDataItem('password', $password);
    }

    public function getAge() {
        return $this->getDataItem('age');
    }

    // Function to set users age with index age
    public function setAge($age) {
        return $this->setDataItem('age', $age);
    }

    public function getGender() {
        return $this->getDataItem('gender');
    }

    // Function to set users gender with index gender
    public function setGender($gender) {
        return $this->setDataItem('gender', $gender);
    }
    
    public function getPhoto() {
        return $this->getDataItem('photo');
    }
    /**
     * 
     * @param type $photo
     * @return type
     */
    public function setPhoto($photo) {
        return $this->setDataItem('photo', $photo);
    }

    public function getCreatedAt() {
        
    }

    public function setCreatedAt() {
        
    }

    public function getUpdatedAt() {
        
    }

    public function setUpdatedAt() {
        
    }

    public function getDataItem($data_idx) {
        return $this->data[$data_idx] ?? null;
    }

    public function setDataItem($data_idx, $data_value) {
        $this->data[$data_idx] = $data_value;
    }

}
