<?php

namespace Migration;

use Core\Table;

class AccountsTable extends Table
{
    protected function up()
    {
        Table::create('accounts', function() {
            $this->primaryKey('id');
            $this->int('user_id');
            $this->float('money')->defaultValue(0);
            $this->timestamp('created_at')->defaultValue('now()');
        });
    }

    protected function data()
    {
        $data['user_id'] = 1;
        $data['money'] = 40000000;

        Table::insert('accounts', $data);
    }
}
