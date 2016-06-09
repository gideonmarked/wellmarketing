<?php namespace Grinkomeda\Networker\Components;

use Cms\Classes\ComponentBase;
use Grinkomeda\Networker\Models\Profile;
use Grinkomeda\Networker\Models\Account;
use Grinkomeda\Networker\Models\Finance;
use Auth;

class Connections extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Connections Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        if(!Auth::check())
        {
            return null;
        }    

        $user = Auth::getUser();

        $profile = Profile::where('user_id',$user->id)->first();
        $this->page['profile'] = $profile;
        $account = Account::where('user_id',$user->id)->first();
        $this->page['account'] = $account;
        $this->page['earnings'] = Finance::where('to_user',$account['account_code'])->where('type','profit')->sum('amount');
        $account = Account::where('user_id',$user->id)->first();
        $connections = self::getDirectConnections( $account['account_code'] );
        foreach ($connections as $key => $connection) {
            $connections[$key]['profile'] = Profile::where('user_id',$connection['user_id'])->first();
            $connections[$key]['earnings'] = Finance::where('to_user',$connection['account_code'])->where('type','profit')->sum('amount');
        }

    }

    private static function getDirectConnections( $account_code )
    {
        return Account::where('placement_code',$account_code)->get();
    }

}