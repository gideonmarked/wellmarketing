<?php namespace Grinkomeda\Networker\Components;

use Validator;
use Redirect;
use Cms\Classes\ComponentBase;
use Grinkomeda\Networker\Models\Package;
use Grinkomeda\Networker\Models\Ticket;
use Grinkomeda\Networker\Models\Finance;
use Grinkomeda\Networker\Models\Entry;
use Grinkomeda\Networker\Models\Account;

class LevelUp extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'LevelUp Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['packages'] = Package::where('type','rush')->get();
    }

    public function onUpgrade()
    {
        $data = post();

        /*
         * Upgrade user account
         */
        $account = Account::where('user_id',$data['user_id'])->first();
        $account->is_old = true;

        $ticket = Ticket::where('code',$data['ticket_code'])->first();
        $ticket->link_id = $data['user_id'];
        $ticket->purchase_date = date('Y-m-d H:i:s');
        $ticket->link_date = date('Y-m-d H:i:s');
        $ticket->save();

        $entry = new Entry;
        $entry->user_id = $data['user_id'];
        $entry->upgrade_user_id = $data['user_id'];
        $entry->upgrade_package_id = $data['package'];
        $entry->ticket_code = $data['ticket_code'];
        $entry->package_id = $data['package'];
        $entry->creation_date = date('Y-m-d H:i:s');
        $entry->save();

        

        $old_account_level = $account['level_id'];

        $account->level_id = $data["package"];
        $account->save();

        $finance = Finance::upgradeForceMatrix( $account['account_code'], $data["package"], $old_account_level );

        return Redirect::to('account/upgrade-account');
    }

}