<?php namespace Grinkomeda\Networker\Updates;

use Seeder;
use Grinkomeda\Networker\Models\Package;

class SeedPackagesTable extends Seeder
{
    public function run()
    {
        $package = Package::create([
            'level_id'              => 0,
            'title'                 => 'P300',
            'description'           => 'Level 1 Rush Package',
            'type'                  => 'rush',
            'amount'                => '300.00',
            'peso_value'            => '300.00',
            'is_active'             => true
        ]);

        $package = Package::create([
            'level_id'              => 1,
            'title'                 => 'P500',
            'description'           => 'Level 2 Rush Package',
            'type'                  => 'rush',
            'amount'                => '800.00',
            'peso_value'            => '500.00',
            'is_active'             => true
        ]);

        $package = Package::create([
            'level_id'              => 2,
            'title'                 => 'P1500',
            'description'           => 'Level 3 Rush Package',
            'type'                  => 'rush',
            'amount'                => '2300.00',
            'peso_value'            => '1500.00',
            'is_active'             => true
        ]);

        $package = Package::create([
            'level_id'              => 3,
            'title'                 => 'P3000',
            'description'           => 'Level 4 Rush Package',
            'type'                  => 'rush',
            'amount'                => '5300.00',
            'peso_value'            => '3000.00',
            'is_active'             => true
        ]);
    }
}