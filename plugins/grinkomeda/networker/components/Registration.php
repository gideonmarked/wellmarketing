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
        /*
         * Validate input
         */
        $data = post();
        $this->page['data'] = $data;
        $account_code = $this->createAccountCode();
        $data['email'] = "bm" . $account_code . "@temporary.com";
        $is_spill = false;
        /*
         * Register user
         */
        $requireActivation = UserSettings::get('require_activation', false);
        $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
        $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;

        $models_created = array();
        $errors = 0;

        /*
         * Create account
         */
        $models_created['account'] = new Account;
        $models_created['account']->level_id = 1; //this should be a dynamic value
        $models_created['account']->account_code = $account_code;
        $models_created['account']->leader_code = $data["leader_code"];
        if(!is_null(post("placement_code")) && post('placement_code') != "")
        {
            $models_created['account']->placement_code = post("placement_code");
            $models_created['account']->placement_exists = true;
            $is_spill = true;
        }
        else {$models_created['account']->placement_code = $data["leader_code"];}
        $models_created['account']->creation_date = date('Y-m-d H:i:s');

        /*
         * Create profile
         */
        $models_created['profile'] = new Profile;
        $models_created['profile']->first_name = $data["first_name"];
        $models_created['profile']->last_name = $data["last_name"];
        $models_created['profile']->middle_name = $data["middle_name"];
        $models_created['profile']->creation_date = date('Y-m-d H:i:s');

        /*
         * Create entry
         */
        $models_created['entry'] = new Entry;
        $models_created['entry']->ticket_code = $data['ticket_code'];
        $models_created['entry']->package_id = post('package');
        $models_created['entry']->creation_date = date('Y-m-d H:i:s');

        $errors = $errors + $this->validateModels( $models_created );

        /*
         * Check ticket
         */
        $models_created['ticket'] = Ticket::where('code',$data['ticket_code'])->where('link_id',null)->first();
        if( !is_null($models_created['ticket']) && $models_created['ticket']->exists ) {
            $models_created['ticket']->purchase_date = date('Y-m-d H:i:s');
            $models_created['ticket']->link_date = date('Y-m-d H:i:s');
        } else {
            $errors++;
        }
        
        if( $errors == 0 ) {
            $user = new User;
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->password_confirmation = $data['password_confirmation'];
            $user->save();

            $models_created['account']->user_id = $models_created['profile']->user_id = $models_created['entry']->user_id = $models_created['ticket']->link_id = $user->id;
                $this->saveModels( $models_created );


            $package_amount = Package::find($data["package"])->first()['amount'];

            $this->startNetworking( $account_code, $package_amount, 1 );


            /*$finance = Finance::createForceMatrix( $account_code, $data["package"],
                            ($is_spill ? $data["leader_code"] : null ));*/

            $this->page['registered'] = true;
            $this->page['account_code'] = $account_code;

            Auth::login($user);
            return Redirect::to('account/dashboard');
        }
    }

    private function startNetworking( $account_code, $amount, $level )
    {
        $active_counter = 1;
        
        $package_amount = Package::find($package_id)->first()['amount'];
        $active_account = Account::where( 'account_code',$account_code )->first();
        $leader_code = $active_account['leader_code'];
        $children_accounts = Account::where('leader_code', $leader_code)->get();
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