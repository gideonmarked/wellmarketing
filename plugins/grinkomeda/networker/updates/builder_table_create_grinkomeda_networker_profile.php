<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerProfile extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_profile', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->dateTime('creation_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_profile');
    }
}
