<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerLevels extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_levels', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 200);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_levels');
    }
}
