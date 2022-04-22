<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectTo()
    {
        if(Auth::user()->role == '1') //1 = Admin Login
        {
            return 'dashboard';
        }
        elseif(Auth::user()->role == '0') // Normal or Default User Login
        {
            return '/home';
        }
    }

    // Use ANY ONE ===> the above code OR below code
  
    //Second method to Redirect with Message ("STATUS") eg: welcome to dashboard
    protected function authenticated()
    {
        if(Auth::user()->role == '1') //1 = Admin Login
        {
            return redirect('admin/main')->with('status','Welcome to your dashboard');
        }
        elseif(Auth::user()->role == '0') // Normal or Default User Login
        {
            return redirect('/home')->with('status','Logged in successfully');
        }
    }
    public function username()
    {
        return 'username';
    }

}

