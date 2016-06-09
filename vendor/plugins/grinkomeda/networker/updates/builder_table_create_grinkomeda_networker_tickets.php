<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGrinkomedaNetworkerTickets extends Migration
{
    public function up()
    {
        Schema::create('grinkomeda_networker_tickets', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('code', 7);
            $table->decimal('amount', 10, 2);
            $table->dateTime('creation_date');
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('link_date')->nullable();
            $table->integer('link_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grinkomeda_networker_tickets');
    }
}
