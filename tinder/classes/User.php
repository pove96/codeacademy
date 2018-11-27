<?php

class User {

    private $email;
    private $password;
    private $data;

    public function __construct($email, $password, $data) {
        $this->email = $email;
        $this->password = $password;
        $this->data = $data;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getData() {
        return $this->data;
    }

    public function setDataItem($data_idx, $data_value) {
        $this->data[$data_idx] = $data_value;
    }

    public function getDataItem($data_idx) {
        return $this->data[$data_idx] ?? null;
    }

}
