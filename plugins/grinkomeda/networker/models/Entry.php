<?php namespace Grinkomeda\Networker\Models;

use Model;

/**
 * Model
 */
class Entry extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $package_id;
    public $upgrade_package_id;
    public $upgrade_user_id;
    public $rules = [];
    public $customMessages = [
        'ticket_amount_match'   => 'The :attribute amount does not match the package amount.',
        'ticket_amount_match_upgrade'   => 'The :attribute amount does not match the package amount.',
    ];

    public $fillable = [
        'ticket_code','package_id','user_id','creation_date'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grinkomeda_networker_entries';

    public function beforeValidate()
    {
        if($this->package_id)
        {
            // $this->rules['ticket_code'] = 'required|max:7|min:7|alpha_num|ticket_amount_match:' . $this->package_id;
        }

        if($this->upgrade_package_id && $this->upgrade_user_id)
        {
            $this->rules['ticket_code'] = 'required|max:7|min:7|alpha_num|ticket_amount_match_upgrade:' . $this->upgrade_package_id . ',' . $this->upgrade_user_id;
        }
    }
}