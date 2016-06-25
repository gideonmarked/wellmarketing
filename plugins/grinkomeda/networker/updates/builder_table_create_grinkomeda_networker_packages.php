<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerPackages extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_packages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('level_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 200);
            $table->string('type', 20);
            $table->decimal('amount', 10, 2);
            $table->decimal('peso_value', 10, 2);
            $table->integer('is_active')->unsigned()->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_packages');
    }
}
