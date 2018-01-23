<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends Controller
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->redirectPath = '/home';
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
     public function handleProviderCallback($provider)
    {
     //notice we are not doing any validation, you should do it

        $user = Socialite::driver($provider)->user();
         
        // stroing data to our use table and logging them in
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];
     
        Auth::login(User::firstOrCreate($data));

        //after login redirecting to home page
        return redirect('/home');
    }
}
