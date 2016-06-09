<?php namespace Grinkomeda\Networker\Models;

use Model;

/**
 * Model
 */
class Profile extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
                'first_name' => 'required|string|between:2,255',
                'middle_name' => 'required|string|between:2,255',
                'last_name' => 'required|string|between:2,255',
    ];

    public $fillable = [
                'first_name','middle_name','last_name'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'grinkomeda_networker_profiles';
}