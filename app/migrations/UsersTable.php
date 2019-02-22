<?php

namespace Migration;

use Core\Table;

class UsersTable extends Table
{
    protected function up()
    {
        Table::create('users', function() {
            $this->primaryKey('id');
            $this->varchar('name', 100)->nullable();
            $this->int('num')->defaultValue(0);
        });
    }
}
