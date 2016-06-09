<?php namespace Grinkomeda\Networker\Models;

use Model;
use Grinkomeda\Networker\Models\Profile;

/**
 * Model
 */
class Account extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $is_old;
    /*
     * Validation
     */
    public $rules = [];

    public $customMessages = [
        'child_max' => 'The :attribute has reached the maximum usage limit.',
    ];

    public $fillable = ['leader_code','placement_code'];

    public function beforeValidate()
    {
        if(!$this->is_old) {
            if($this->placement_exists) {
                $this->rules['leader_code'] = 'required|max:7|min:7|alpha_num|exists:grinkomeda_networker_accounts,account_code';
                $this->rules['placement_code'] = 'required|max:7|min:7|alpha_num|exists:grinkomeda_networker_accounts,account_code|child_max:5';
            } else {
                $this->rules['leader_code'] = 'required|max:7|min:7|alpha_num|exists:grinkomeda_networker_accounts,account_code|child_max:5';
            }
        }
    }

    public static function upgradeToNextLevel( $account, $level )
    {
        if( $account->level_id == $level )
        {
            $account->upgradeToNext();
        }
    }

    public function upgradeToNext()
    {
        if( $this->level_id < 5 )
        {
            $this->level_id = $this->level_id + 1;
            $this->save();
        }
    }

    public static function getAncestor( $account_code, $levels, $current_level = 1 )
    {
        $parent = Account::where('account_code',$account_code)->first();

        if( $current_level < $levels) {
            return Account::getAncestor( $parent['placement_code'], $levels, $current_level+1 );
        } else {
            return Account::where('account_code',$parent['placement_code'])->first();
        }
    }

    public function getProfileFromAccountCode( $account_code )
    {
        $account = Account::where('account_code',$account_code)->first();
        $profile = Profile::where('user_id',$account['user_id'])->first();
        return $profile;
    }

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $placement_exists;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grinkomeda_networker_accounts';
}