<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerFinance extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->decimal('amount', 10, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->decimal('amount', 10, 0)->change();
        });
    }
}
