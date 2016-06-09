<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerAccounts extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_accounts', function($table)
        {
            $table->string('placement_code', 7);
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_accounts', function($table)
        {
            $table->dropColumn('placement_code');
        });
    }
}
