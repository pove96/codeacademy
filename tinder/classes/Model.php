<?php
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
    
    public function delete($id) {
        $data = $this->db->load();
        unset($data[$this->table_name][$id]);
        $this->db->save($data);
    }
    
    public function loadAll() {
        $data = $this->db->load();
        return $data[$this->table_name] ?? null;
    }
}