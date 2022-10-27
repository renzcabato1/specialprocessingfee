<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/for-review';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // protected function redirectTo()
    // {
    //     dd('-------------');
    //     if (Auth::check() && Auth::user()->role_id == 1) {
    //         return redirect('/');
    //     } elseif (Auth::check() && Auth::user()->role_id == 3) {
    //         return redirect('requests');
    //     } elseif (Auth::check() && Auth::user()->role_id == 4) {
    //         return redirect('for-review');
    //     } else {
    //         return redirect('for-verification');
    //     }
    // }
}
