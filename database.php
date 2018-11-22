<?php
class Database {
    
    private $naujasfailas;
    public function __construct($naujasfailas) {
        $this->naujasfailas = $naujasfailas;
        $this->init();
    }
    
    public function init() {
        if (!file_exists($this->naujasfailas)) {
          file_put_contents($this->naujasfailas, '');
        }
    }
    
    public function load() {
        $content = file_get_contents($this->naujasfailas);
        return unserialize($content);
    }
    
    public function save($content) {
        file_put_contents($this->naujasfailas, serialize($content));
    }
    
    public function delete() {
        unlink($this->naujasfailas);
    }
}

class Model {
    
    private $db;
    private $table_name;
    
    public function __construct(Database $db, $table_name) {
        $this->db = $db;
        $this->table_name = $table_name;
    }
    
    public function insertOrUpdate($id, $record) {
        //issitraukt data is db kuri yra
        $data = $this->db->load();
        
        $data[$this->table_name][$id] = $record;
        $this->db->save($data);
    }
    
    public function load($id) {
        $data = $this->db->load();
        $record = $data[$this->table_name][$id] ?? null;
        return $record;
    }
    
    public function delete() {
        $data = $this->db->load();
        unset($data[$this->table_name][$id]);
        $this->db->save($data);
    }
}

//$db = new Database('naujasfailas.txt');
//$users = new Model($db, 'users');
//$users->insertOrUpdate(1, ['name', 'password']);
//var_dump($db->load());