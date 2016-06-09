<?php namespace Grinkomeda\Networker;

use System\Classes\PluginBase;
use Validator;
use Grinkomeda\Networker\Models\Package;
use Grinkomeda\Networker\Models\Ticket;
use Grinkomeda\Networker\Models\Account;
use Grinkomeda\Networker\Models\Profile;
use Grinkomeda\Networker\Models\Finance;
use Grinkomeda\Networker\Models\Entry;

class Plugin extends PluginBase
{
	public function pluginDetails()
    {
        return [
            'name'        => 'Grinkomeda Networker',
            'description' => 'Managers a business networking system.',
            'author'      => 'Gideon Mark Cabelin Pacete',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
    	return [
            '\Grinkomeda\Networker\Components\Registration' => 'registration',
            '\Grinkomeda\Networker\Components\Login' => 'login',
            '\Grinkomeda\Networker\Components\LevelUp' => 'levelUp',
            '\Grinkomeda\Networker\Components\TicketFactory' => 'ticketFactory',
        ];
    }

    public function registerSettings()
    {
    	return [];
    }

    public function boot()
    {
        Validator::extend('child_max', function($attribute, $value, $parameters, $validator) {
            $account = Account::where('leader_code',$value)->get();
            return count($account) < $parameters[0];
        });

        Validator::extend('ticket_amount_match', function($attribute, $value, $parameters, $validator) {
            $ticket = Ticket::where('code',$value)->first();
            $package = Package::where('level_id',$parameters[0])->first();
            return $package['amount'] == $ticket['amount'];
        });

        Validator::extend('ticket_amount_match_upgrade', function($attribute, $value, $parameters, $validator) {
            $ticket = Ticket::where('code',$value)->first();
            $packages = Package::where('type','rush')->get();
            $account_level = Account::where('user_id', $parameters[1])->first()['level_id'];
            
            $calculated_amount = 0.0;
            foreach ($packages as $key => $package) {
                if( $package['level_id'] > $account_level && $package['level_id'] <= $parameters[0] )
                    $calculated_amount += $package['peso_value'];
            }
            return $calculated_amount == $ticket['amount'];
        });
    }
}
