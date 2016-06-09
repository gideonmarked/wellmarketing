<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerFinance3 extends Migration
{
    public function up()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->string('to_user', 7)->nullable(false)->unsigned(false)->default(null)->change();
            $table->string('from_user', 7)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('grinkomeda_networker_finance', function($table)
        {
            $table->integer('to_user')->nullable(false)->unsigned()->default(null)->change();
            $table->integer('from_user')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
