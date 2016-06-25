<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerProducts extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 200);
            $table->decimal('amount', 10, 2);
            $table->integer('is_active')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_products');
    }
}
