<?php namespace Grinkomeda\Networker\Components;

use Cms\Classes\ComponentBase;
use Grinkomeda\Networker\Models\Finance;
use Grinkomeda\Networker\Models\Account;
use RainLab\User\Models\User;

class ViewFinance extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ViewFinance Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->getFinance();
    }

    private function getFinance()
    {

        User::extend(function($model){
            var_dump($model);
        });
        // $account = Account::where('user_id',$this->user->id)->first();

        // $transactions = Finance::where('to_user',$account['account_code'])->where('description','!=','package payment')->where('type','profit')->get();

        // $pendings = Finance::where('to_user',$account['account_code'])->where('description','!=','package payment')->where('type','pending')->get();

        // $this->page['transactions'] = $transactions;
        // $this->page['pendings'] = $pendings;
        // $this->page['account'] = $account;
    }

}