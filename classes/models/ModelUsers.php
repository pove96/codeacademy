<?php

class ModelUsers extends Model {

    /**
     * Creates a new table to the database
     * @throws Exception
     */
    public function create() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (" .
                "email VARCHAR(249) NOT NULL PRIMARY KEY," .
                "password VARCHAR(32) NOT NULL," .
                "full_name VARCHAR(255)," .
                "age TINYINT," .
                "gender CHAR(1)," .
                "photo VARCHAR(255)," .
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
     * Inserts user with his data to the table
     * 
     * @param string $email
     * @param string $data
     * @return string lastInsertId()
     */
    public function insert($email, $data = []) {
        $row = $data;
        $row['email'] = $email;

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

    /**
     * 
     * Loads user by his email
     * 
     * @param string $email
     * @return array records
     */
    public function load($email) {
        $sql = strtr('SELECT * FROM @table WHERE @column = @column_bind;', [
            '@table' => $this->table_name,
            '@column' => SQLBuilder::column('email'),
            '@column_bind' => SQLBuilder::bind('email')
        ]);
        $query = $this->db_c->prepare($sql);
        $query->bindValue(SQLBuilder::bind('email'), $email);

        $query->execute();
        //$query->debugDumpParams();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * Loads all user from the table
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
     * Updates user with his data 
     * 
     * @param string $email
     * @param string $data
     * @return boolean success
     */
    public function update($email, $data = []) {

        $sql = strtr('UPDATE @table SET @column_binds WHERE @column = @column_bind;', [
            '@table' => $this->table_name,
            '@column_binds' => SQLBuilder::columnsEqualBinds(array_keys($data)),
            '@column' => SQLBuilder::column('email'),
            '@column_bind' => SQLBuilder::bind('email')
        ]);

        $query = $this->db_c->prepare($sql);
        $query->bindValue(SQLBuilder::bind('email'), $email);

        foreach ($data as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }

        return $query->execute();
    }

    /**
     * 
     * Deletes user from the table
     * 
     * @param string $email
     * @return boolean success
     */
    public function delete($email) {
        $sql = strtr('DELETE FROM @table WHERE @column = @column_bind;', [
            '@table' => $this->table_name,
            '@column' => SQLBuilder::column('email'),
            '@column_bind' => SQLBuilder::bind('email')
        ]);

        $query = $this->db_c->prepare($sql);
        $query->bindValue(SQLBuilder::bind('email'), $email);
        return $query->execute();
    }

}
