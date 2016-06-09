<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerFinance2 extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->dateTime('transaction_date');
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->dropColumn('transaction_date');
        });
    }
}
