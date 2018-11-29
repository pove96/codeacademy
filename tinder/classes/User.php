<?php

class User {

    private $email;
    private $data;

    public function __construct($email, $data) {
        $this->email = $email;
        $this->data = $data;
    }

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

    public function setFullName($full_name) {
        return $this->setDataItem('full_name', $full_name);
    }

    public function getPassword() {
        return $this->getDataItem('password');
    }

    public function setPassword($password) {
        return $this->setDataItem('password', $password);
    }

    public function getAge() {
        return $this->getDataItem('age');
    }

    public function setAge($age) {
        return $this->setDataItem('age', $age);
    }

    public function getGender() {
        return $this->getDataItem('gender');
    }

    public function setGender($gender) {
        return $this->setDataItem('gender', $gender);
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
