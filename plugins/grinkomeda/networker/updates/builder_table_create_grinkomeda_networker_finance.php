<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerFinance extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_finance', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('to_user')->unsigned();
            $table->integer('from_user')->unsigned();
            $table->decimal('amount', 10, 0);
            $table->string('type', 20);
            $table->string('description', 20);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_finance');
    }
}
