<?php

namespace Migration;

use Core\Table;

class ProductsTable extends Table
{
    protected function up()
    {
        Table::create('products', function() {
            $this->primaryKey('id');
            $this->float('money');
            $this->int('num');
        });
    }
}
