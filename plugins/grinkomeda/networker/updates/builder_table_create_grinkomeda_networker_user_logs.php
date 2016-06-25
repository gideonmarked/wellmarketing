<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerUserLogs extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_user_logs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('status', 50);
            $table->dateTime('log_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_user_logs');
    }
}
