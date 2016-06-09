<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerAccounts extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_accounts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('level_id');
            $table->string('account_code', 7);
            $table->string('leader_code', 7);
            $table->dateTime('creation_date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_accounts');
    }
}
