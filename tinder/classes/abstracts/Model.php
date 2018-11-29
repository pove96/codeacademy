<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author CodeAcademy
 */
abstract class Model {
    /**
     *
     * @var D
     */
    protected $db;
    protected $db_c;
    protected $table_name;

    public function __construct(MysqlDatabase $db, $table_name) {
        $this->db = $db;
        $this->db_c = $db->getConnection();
        $this->table_name = $table_name;
        $this->init();
    }

    public function init() {
        $results = $this->db_c->query("SHOW TABLES LIKE '$this->table_name';");
        if ($results->rowCount() == 0) {
            $this->create();
        }
    }

    /**
     * Creates table
     */
    abstract public function create();

    abstract public function load($id);

    abstract public function loadAll();

    abstract public function insert($id, $data = []);

    abstract public function update($id, $data = []);

    abstract public function delete($id);

    public function deleteAll() {
        $sql = strtr('TRUNCATE @table;', [
            '@table' => $this->table_name
        ]);
        return $this->db_c->execute($sql);
    }

}
