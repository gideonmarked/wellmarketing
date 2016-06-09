<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerPackages extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_packages', function($table)
        {
            $table->decimal('peso_value', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_packages', function($table)
        {
            $table->dropColumn('peso_value');
        });
    }
}
