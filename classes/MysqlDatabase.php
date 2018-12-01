<?php

class MysqlDatabase {

    private $user;
    private $pass;
    private $host;
    private $conn;
    private $db_name;

    public function __construct($user, $pass, $host, $db_name) {
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->db_name = $db_name;
        // Connection instance with MySQL
        $this->conn = null;
        $this->init();
    }
    
    public function connect() {
        if (!$this->conn) {
            $this->conn = new PDO("mysql:host=$this->host", $this->user, $this->pass);

            if (!$this->conn) {
                throw new Exception("Cannot connect to database!");
            }
            if (DEBUG) {
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
        }
    }

    public function init() {
        $this->connect();
        $query = $this->conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA "
                . "WHERE SCHEMA_NAME = '$this->db_name'");

        if (!(bool) $query->fetchColumn()) {
            $this->create();
        }
        $this->conn->exec("use $this->db_name;");

        return $this->conn;
    }

    public function create() {
        try {
            $this->conn->exec("CREATE DATABASE `$this->db_name`;
                CREATE USER '$this->user'@'localhost' IDENTIFIED BY '$this->pass';
                GRANT ALL ON `$this->db_name`.* TO '$this->user'@'$this->host';
                FLUSH PRIVILEGES;");
        } catch (PDOException $e) {
            throw("Database Error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

}
