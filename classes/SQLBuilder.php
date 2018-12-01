<?php

/**
 * Description of SQLBuilder
 */
class SQLBuilder {

    //put your code here
    public static function column($column) {
        return "`$column`";
    }

    public static function columns($column_array) {
        foreach ($column_array as &$column) {
            $column = self::column($column);
        }

        return implode(', ', $column_array);
    }

    public static function bind($column) {
        return ':' . str_replace(' ', '_', $column);
    }

    public static function binds($column_array) {
        foreach ($column_array as &$column) {
            $column = self::bind($column);
        }

        return implode(', ', $column_array);
    }

    public static function columnEqualBind($column) {
        return self::column($column) . '=' . self::bind($column);
    }

    public static function columnsEqualBinds($column_array) {
        $columns_eq_binds = [];
        foreach ($column_array as $column) {
            $columns_eq_binds[] = self::columnEqualBind($column);
        }

        return implode(', ', $columns_eq_binds);
    }

    public static function value($value) {
        return "'$value'";
    }

    public static function values($row_array) {
        foreach ($row_array as &$value) {
            $value = "'$value'";
        }

        return implode(', ', array_keys($row_array));
    }

}
