<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerEntries extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_entries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('ticket_code', 7);
            $table->integer('package_id')->nullable();
            $table->dateTime('creation_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_entries');
    }
}
