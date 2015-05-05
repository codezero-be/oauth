<?php

// Add the ServiceProvider

// Create the oauth-providers config file

// Create a route:

Route::get('login/{provider}', ['uses' => 'SocialController@login']);

// Create a controller:

use CodeZero\OAuth\Contracts\Authenticator;
use Illuminate\Routing\Controller;

class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login($provider, Authenticator $auth)
    {
        $details = $auth->request($provider);

        if ($details) {
            var_dump($details->getEmail());
            var_dump($details->getFirstName());
            var_dump($details->getLastName());
        } else {
            echo 'User canceled!';
        }

        die();

        return redirect()->intended('/');
    }
}
