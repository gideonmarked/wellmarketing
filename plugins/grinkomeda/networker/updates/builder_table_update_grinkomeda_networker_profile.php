<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerProfile extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_profile', function($table)
        {
            $table->string('first_name', 50)->change();
            $table->string('last_name', 50)->change();
            $table->string('middle_name', 50)->change();
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_profile', function($table)
        {
            $table->string('first_name', 255)->change();
            $table->string('last_name', 255)->change();
            $table->string('middle_name', 255)->change();
        });
    }
}
