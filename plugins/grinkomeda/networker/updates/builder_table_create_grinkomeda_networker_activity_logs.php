<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerActivityLogs extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_activity_logs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('reference_table', 50);
            $table->string('action', 20);
            $table->dateTime('log_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_activity_logs');
    }
}
