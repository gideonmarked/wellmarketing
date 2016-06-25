<?php namespace Grinkomeda\Networker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGrinkomedaNetworkerProfiles extends Migration
{
    public function up()
    {
        Schema::rename('grinkomeda_networker_profile', 'grinkomeda_networker_profiles');
    }
    
    public function down()
    {
        Schema::rename('grinkomeda_networker_profiles', 'grinkomeda_networker_profile');
    }
}
