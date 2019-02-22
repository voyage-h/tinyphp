<?php

namespace Core;

class Table extends Model
{
    public $ddl;
    public $sql;

    public $recreate = false;

    protected function dropTable()
    {
        $this->recreate = true;
    }

    protected function create($table, $func)
    {
        $this->table = $table;
        $pre = $this->recreate ? "Drop table if exists `$table`;" : '';
        $this->ddl[] = "{$pre}CREATE TABLE `$table` (";

        call_user_func($func);
    }

    public function primaryKey($field)
    {
        $this->ddl[0] .= "`$field` int(10) unsigned not null primary key auto_increment";
    }

    public function __call($method, $args)
    {
        if ($this->sql) {
            $this->ddl[] = $this->sql;
        }
        $field = current($args);

        $length = $args[1] ? '('.$args[1].')' : '';

        $this->sql = "`$field` $method{$length} not null";
        return $this;
    }
    public function nullable()
    {
        $this->sql = str_replace('not null', '', $this->sql);    
        return $this;
    }

    public function defaultValue($value)
    {
        if ($value == '') {
            $value = "'$value'";
        }
        $this->sql .= " default $value";
        return $this;
    }

    public function __destruct()
    {
        $this->ddl[] = $this->sql.
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $sql = implode($this->ddl, ', ');
        $res = $this->query($sql);

        if ($res !== true) {
            echo "Table '$this->table' created failed: ".$res[2]."\n";
        } else {
            echo "Table $this->table created success\n";
        }
    }
}
