<?php namespace Grinkomeda\Networker\Updates;

use Seeder;
use Grinkomeda\Networker\Models\Level;

class SeedLevelsTable extends Seeder
{
    public function run()
    {
        $level = Level::create([
            'title'                 => 'Account Level 1',
            'description'           => 'Account Level 1'
        ]);

        $level = Level::create([
            'title'                 => 'Account Level 2',
            'description'           => 'Account Level 2'
        ]);

        $level = Level::create([
            'title'                 => 'Account Level 3',
            'description'           => 'Account Level 3'
        ]);

        $level = Level::create([
            'title'                 => 'Account Level 4',
            'description'           => 'Account Level 4'
        ]);
    }
}