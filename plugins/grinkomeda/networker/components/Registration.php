<?php namespace Grinkomeda\Networker\Components;


use October\Rain\Database\Traits\Validation;
use Redirect;
use Auth;
use Flash;
use Event;
use Cms\Classes\ComponentBase;
use October\Rain\Exception\ApplicationException;
use Grinkomeda\Networker\Models\Package;
use Grinkomeda\Networker\Models\Ticket;
use Grinkomeda\Networker\Models\Account;
use Grinkomeda\Networker\Models\Profile;
use Grinkomeda\Networker\Models\Finance;
use Grinkomeda\Networker\Models\Entry;
use RainLab\User\Models\User;
use RainLab\User\Models\Settings as UserSettings;

class Registration extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Registration Component',
            'description' => 'Adds a registration form for profile and account creation'
        ];
    }

    public function onRun()
    {
        $this->getPackages();
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRegister()
    {
        echo 'hasds';
    }

    private function startNetworking( $account_code, $amount, $level )
    {
        $active_counter = 1;
        
        $package_amount = Package::find($package_id)->first()['amount'];
        $active_account = Account::where( 'account_code',$account_code )->first();
        $leader_code = $active_account['leader_code'];
        $children_accounts = Account::getAncestralChildren( $leader_code, $level );
        $finance_list = array(
             500,
             750,
             1125,
             1686,
             2529
            );

        Finance::createPendingUpgrade( $account_code, $amount, $level);

        if(count($children_accounts) == 3) {
            Finance::convertPendingToUpgrade($children_accounts,$level,$amount);
            $leader_account = Account::where( 'account_code', $active_account['leader_code'] )->first();
            Account::upgradeToNextLevel( $leader_account, $level );
        }

        if(count($children_accounts) > 3) {
            Finance::addExtraProfit($children_accounts,$level,$amount);
        }



        if($account_code != $active_account['leader_code']) {
            $this->startNetworking( $active_account['leader_code'], $finance_list[$level], $level+1 );
        }
    }

    public function validateModels( $models_created ) {
        $errors = 0;
        foreach ($models_created as $model) {
            if(!is_null($model))
                $errors += ($model->validate() ? 0 : 1);
        }
        return $errors;
    }

    public function saveModels( $models_created ) {
        foreach ($models_created as $key => $model) {
            $model->save();
        }
    }

    public function getPackages()
    {
        $packages = Package::select('level_id','description','amount')->where('id',6)->get();
        $this->page['packages'] = $packages;
    }

    private function createAccountCode()
    {
        $account_code = $this->randomGeneration(7);
        return $account_code;
    }

    private function randomGeneration($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }

        if( $this->checkUniqueTickets( $string ) ) {
            return $string;
        } else {
            return $this->randomGeneration($length);
        }
    }

    private function checkUniqueTickets( $string )
    {
        $ticketlist = Account::where('account_code',$string)->get();
        if(count($ticketlist) > 0) {
            return false;
        } else {
            return true;
        }
    }

}