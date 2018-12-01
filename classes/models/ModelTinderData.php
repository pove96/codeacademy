<?php

class ModelTinderData {

    /**
     * 
     * Class which is responsible for working with tinder data
     * 
     * MySQL Database
     * @var MysqlDatabase
     */
    protected $db;

    /**
     * Database connection
     * @var PDO
     */
    protected $db_c;

    /**
     * Table name
     * @var string
     */
    protected $table_name;

    public function __construct(MysqlDatabase $db, $table_name) {
        $this->db = $db;
        $this->db_c = $db->getConnection();
        $this->table_name = $table_name;
        $this->init();
    }

    /**
     * Creates a new table in database
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
     * Checks if table exists, 
     * if not, initiates create() function
     */
    public function init() {
        $results = $this->db_c->query("SHOW TABLES LIKE '$this->table_name';");
        if ($results->rowCount() == 0) {
            $this->create();
        }
    }

    /**
     * 
     * Inserts User and his viewed users to the table
     * 
     * @param string $email_user
     * @param string $email_user_viewed
     * @param string $action
     * @return string lastInsertId()0.25
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
        // Prepares the binded sql
        $query = $this->db_c->prepare($sql);
        // Binds all values
        foreach ($row as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }
        // Executes the query
        $query->execute();

        return $this->db_c->lastInsertId();
    }

    /**
     * 
     * Loads user data by his email
     * 
     * @param string $email_user
     * @return array records
     */
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

    /**
     * 
     * Loads user data by its email and action
     * 
     * @param string $email_user
     * @param string $action (like, dislike)
     * @return array records
     */
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

    /**
     * 
     * Loads all the data from the table
     * 
     * @return array records
     */
    public function loadAll() {
        $sql = strtr('SELECT * FROM @table', [
            '@table' => $this->table_name
        ]);
        $query = $this->db_c->query($sql);

        //$query->debugDumpParams();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * Updates user with his viewed user and his action (like or dislike)
     * 
     * @param string $email_user
     * @param string $email_user_viewed
     * @param string $action
     * @return boolean success
     */
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

    /**
     * 
     * Deletes user data by email and its viewed user
     * 
     * @param type $email_user
     * @param type $email_user_viewed
     * @return boolean success
     */
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
