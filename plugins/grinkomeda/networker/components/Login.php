<?php namespace Grinkomeda\Networker\Components;

use Auth;
use Event;
use Validator;
use ValidationException;
use Redirect;
use ApplicationException;
use Cms\Classes\ComponentBase;
use RainLab\User\Models\User;
use RainLab\User\Models\Settings as UserSettings;

class Login extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Login Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onSignIn()
    {
        /*
         * Validate input
         */
        $data = post();
        $rules = [];

        $rules['username'] = 'required|between:2,255|exists:users,username';
        $rules['password'] = 'required|between:4,255';

        if (!array_key_exists('username', $data)) {
            $data['username'] = post('username');
        }

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return Redirect::to('account/login')->withErrors($validation);
        }

        /*
         * Authenticate user
         */
        $email = User::where('username',array_get($data, 'username'))->first()['email'];
        $credentials = [
            'login'    => $email,
            'password' => array_get($data, 'password')
        ];

        // Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);

        $user = Auth::authenticate($credentials, true);

        /*
         * Redirect to the intended page after successful sign in
         */

        if ($user) {
            return Redirect::to('account/dashboard');
        }
    }

}