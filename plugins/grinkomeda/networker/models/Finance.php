<?php namespace Grinkomeda\Networker\Models;

use Model;
use Auth;
use Grinkomeda\Networker\Models\Account;
use Grinkomeda\Networker\Models\Package;

/**
 * Model
 */
class Finance extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];

    public static function createPendingUpgrade($account_code,$amount,$level)
    {
        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = $leader_code;
        $finance->amount = $amount / 2;
        $finance->type = 'pending';
        $finance->description = 'upgrade level ' . $level;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->to_user = 'BOBMK16';
        $finance->to_user = $account_code;
        $finance->amount = $amount / 2;
        $finance->type = 'profit';
        $finance->description = 'package payment level ' . $level;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->from_user = 'BOBMK16';
        $finance->to_user = 'GNKMDSD';
        $finance->amount = $package['amount'] * 0.03;
        $finance->type = 'expense';
        $finance->description = 'system development ref: '. $account_code;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();
    }

    public static function convertPendingToUpgrade($accounts,$level,$amount) 
    {
        foreach ($accounts as $key => $account) {
            $finance_upgrade = Finance::where('from_user',$account->account_code)
                                ->where('to_user',$account->account_code)
                                ->where('type','pending')
                                ->where('description','upgrade level ' . $level)
                                ->first();
            $finance_upgrade->type = 'profit';
            $finance_upgrade->save();
        }
    }

    public static function createForceMatrix($account_code, $level, $leader_code)
    {
        for ($i=1; $i <= $level; $i++) { 
            $parent = Account::getAncestor($account_code,$i);
            $package = Package::where('level_id',$i)->where('type','regular')->first();
            if( $parent['level_id'] >= $i ) {
                $finance = new Finance;
                $finance->from_user = $account_code;
                $finance->to_user = (   !is_null($leader_code) 
                                        && $i == 1 ? $leader_code
                                        : $parent['account_code']  );
                $finance->amount = $package['peso_value'] * 0.5;
                $finance->type = 'profit';
                $finance->description = 'direct referral' . $i;
                $finance->transaction_date = date('Y-m-d H:i:s');
                $finance->save();
            } else {
                $finance = new Finance;
                $finance->from_user = $account_code;
                $finance->to_user = (   !is_null($leader_code) 
                                        && $i == 1 ? $leader_code
                                        : $parent['account_code']  );
                $finance->amount = $package['peso_value'] * 0.5;
                $finance->type = 'pending';
                $finance->description = 'direct referral' . $i;
                $finance->transaction_date = date('Y-m-d H:i:s');
                $finance->save();
            }
        }
        
        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = 'BOBMK16';
        $finance->amount = $package['amount'];
        $finance->type = 'profit';
        $finance->description = 'package payment';
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = 'GNKMDSD';
        $finance->amount = $package['amount'] * 0.03;
        $finance->type = 'expense';
        $finance->description = 'system development';
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();
    }

    public static function upgradeForceMatrix($account_code, $level, $from_level)
    {
        $account = Account::where('account_code',$account_code)->first();
        $amount_to_be_paid = 0.0;
        for ($i = $from_level+1; $i <= $level; $i++) { 
            $parent = Account::getAncestor($account_code,$i);
            $package = Package::where('level_id',$i)->where('type','regular')->first();
            if( $parent['level_id'] >= $i ) {
                
                $finance = new Finance;
                $finance->from_user = $account_code;
                $finance->to_user = $parent['account_code'];
                $finance->amount = $package['peso_value'] * 0.5;
                $finance->type = 'profit';
                $finance->description = 'direct referral' . $i;
                $finance->transaction_date = date('Y-m-d H:i:s');
                $finance->save();

                $amount_to_be_paid += $package['peso_value'];
            } else {
                $finance = new Finance;
                $finance->from_user = $account_code;
                $finance->to_user = $parent['account_code'];
                $finance->amount = $package['peso_value'] * 0.5;
                $finance->type = 'pending';
                $finance->description = 'direct referral' . $i;
                $finance->transaction_date = date('Y-m-d H:i:s');
                $finance->save();

                $amount_to_be_paid += $package['peso_value'];
            }
        }
        
        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = 'BOBMK16';
        $finance->amount = $amount_to_be_paid;
        $finance->type = 'profit';
        $finance->description = 'package payment';
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = 'GNKMDSD';
        $finance->amount = $amount_to_be_paid * 0.03;
        $finance->type = 'expense';
        $finance->description = 'system development';
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();
    }

    public static function createPendingUpgrade( $account_code, $leader_code, $amount, $level_id )
    {
        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = $leader_code;
        $finance->amount = $amount / 2;
        $finance->type = 'pending';
        $finance->description = 'upgrade level ' . $level_id;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->to_user = 'BOBMK16';
        $finance->to_user = $account_code;
        $finance->amount = $amount / 2;
        $finance->type = 'profit';
        $finance->description = 'package payment level ' . $level_id;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();
    }

    public static function createUpgrade( $account_code, $leader_code, $amount, $level_id )
    {
        $finance = new Finance;
        $finance->from_user = $account_code;
        $finance->to_user = $leader_code;
        $finance->amount = $amount / 2;
        $finance->type = 'pending';
        $finance->description = 'upgrade level ' . $level_id;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        $finance = new Finance;
        $finance->to_user = 'BOBMK16';
        $finance->to_user = $account_code;
        $finance->amount = $amount / 2;
        $finance->type = 'profit';
        $finance->description = 'package payment level ' . $level_id;
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();
    }

    public static function requestCheck()
    {
        if(!Auth::check())
        {
            return null;
        }    

        $user = Auth::getUser();
        
        $account = Account::where('user_id',$user->id)->first();

        $finance = new Finance;
        $finance->from_user = $account['account_code'];
        $finance->to_user = 'BOBMK16';
        $finance->amount = self::getCalculatedProfit($account['account_code']);
        $finance->type = 'claim';
        $finance->description = 'check request';
        $finance->transaction_date = date('Y-m-d H:i:s');
        $finance->save();

        return Redirect::to('account/dashboard');
    }

    private static function getCalculatedProfit( $account_code )
    {
        $profit = Finance::where('to_user',$account_code)->where('type','profit')->sum('amount');
        $expense = Finance::where('from_user',$account_code)->where('type','expense')->sum('amount');
        $claims = Finance::where('from_user',$account_code)->where('type','claim')->sum('amount');
        $new_claim = $profit - $expense - $claims;
        return $new_claim;
    }

    public static function test() {
        $parent_code = Account::getAncestor('N6VBOX4',1);
    }

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grinkomeda_networker_finance';
}