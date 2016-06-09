<?php namespace Grinkomeda\Networker\Updates;

use Seeder;
use Grinkomeda\Networker\Models\Account;
use RainLab\User\Models\User;

class SeedUserAccountTable extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name'                    => 'BOB',
            'surname'                 => 'Marketing',
            'email'                   => 'grinkomedastudiosph@gmail.com',
            'password'                => 'BM1234567',
            'password_confirmation'   => 'BM1234567',
            'username'                => 'BOBM2016',
            'is_activated'            => 1
        ]);

        $account = Account::create([
            'user_id'                   => 1,
            'level_id'                  => 4,
            'account_code'              => 'BOBMK16',
            'leader_code'               => 'BOBMK16'
        ]);
    }
}