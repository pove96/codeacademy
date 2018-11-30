<?php

class ModelTinderData {

    protected $db;
    protected $db_c;
    protected $table_name;

    public function __construct(MysqlDatabase $db, $table_name) {
        $this->db = $db;
        $this->db_c = $db->getConnection();
        $this->table_name = $table_name;
        $this->init();
    }
    /**
     * 
     * SQL to create a new table if it does not exist
     * 
     * @throws Exception
     */
    public function create() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (" .
                "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY," .
                "email_user VARCHAR(50) NOT NULL," .
                "email_user_viewed VARCHAR(50) NOT NULL," .
                "action VARCHAR(10)," .
                "created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP," .
                "updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
                . ");";

        try {
            $this->db_c->exec($sql);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * 
     */
    public function init() {
        $results = $this->db_c->query("SHOW TABLES LIKE '$this->table_name';");
        if ($results->rowCount() == 0) {
            $this->create();
        }
    }
    /**
     * 
     * 
     * 
     * @param type $email_user
     * @param type $email_user_viewed
     * @param type $action
     * @return type
     */
    public function insert($email_user, $email_user_viewed, $action = '') {
        $row = [
            'email_user' => $email_user,
            'email_user_viewed' => $email_user_viewed,
            'action' => $action
        ];

        $sql = strtr('INSERT INTO @table ( @columns ) VALUES ( @column_binds );', [
            '@table' => $this->table_name,
            '@columns' => SQLBuilder::columns(array_keys($row)),
            '@column_binds' => SQLBuilder::binds(array_keys($row))
        ]);
        $query = $this->db_c->prepare($sql);
        foreach ($row as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }

        $query->execute();

        return $this->db_c->lastInsertId();
    }

    public function load($email_user) {
        $sql = strtr('SELECT * FROM @table WHERE @condition;', [
            '@table' => $this->table_name,
            '@condition' => SQLBuilder::columnEqualBind('email_user'),
        ]);

        $query = $this->db_c->prepare($sql);
        $query->bindValue(SQLBuilder::bind('email_user'), $email_user);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadByAction($email_user, $action) {
        $sql = strtr('SELECT * FROM @table WHERE @condition1 AND @condition2;', [
            '@table' => $this->table_name,
            '@condition1' => SQLBuilder::columnEqualBind('email_user'),
            '@condition2' => SQLBuilder::columnEqualBind('action')
        ]);

        $query = $this->db_c->prepare($sql);
        $query->bindValue(SQLBuilder::bind('email_user'), $email_user);
        $query->bindValue(SQLBuilder::bind('action'), $action);
  
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    public function loadAll() {
        $sql = strtr('SELECT * FROM @table', [
            '@table' => $this->table_name
        ]);
        $query = $this->db_c->query($sql);

        //$query->debugDumpParams();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($email_user, $email_user_viewed, $action) {
        $updates = [
            'action' => $action
        ];

        $conditions = [
            'email_user' => $email_user,
            'email_user_viewed' => $email_user_viewed
        ];

        $sql = strtr('UPDATE @table SET @updates WHERE @condition1 AND @condition2;', [
            '@table' => $this->table_name,
            '@updates' => SQLBuilder::columnsEqualBinds(array_keys($updates)),
            '@condition1' => SQLBuilder::columnEqualBind('email_user'),
            '@condition2' => SQLBuilder::columnEqualBind('email_user_viewed'),
        ]);

        $query = $this->db_c->prepare($sql);

        foreach ($updates as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }

        foreach ($conditions as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }

        return $query->execute();
    }

    public function delete($email_user, $email_user_viewed) {
        $sql = strtr('DELETE FROM @table WHERE @condition1 AND @condition2;', [
            '@table' => $this->table_name,
            '@condition1' => SQLBuilder::columnEqualBind('email_user'),
            '@condition2' => SQLBuilder::columnEqualBind('email_user_viewed')
        ]);

        $query = $this->db_c->prepare($sql);
        
        $query->bindValue(SQLBuilder::bind('email_user'), $email_user);
        $query->bindValue(SQLBuilder::bind('email_user_viewed'), $email_user_viewed);

        return $query->execute();
    }

}