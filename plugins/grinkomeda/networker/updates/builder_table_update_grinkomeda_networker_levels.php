<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerLevels extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_levels', function($table)
        {
            $table->decimal('profit', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_levels', function($table)
        {
            $table->dropColumn('profit');
        });
    }
}
