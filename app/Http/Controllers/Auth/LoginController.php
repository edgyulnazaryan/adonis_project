<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


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
    protected $redirectTo =  RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:employer')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials) || Auth::guard('employer')->attempt($request->only(['email','password']), $request->get('remember'))){
            if (!is_null(Auth::user()) && Auth::user()->is_admin) {
                $this->middleware('admin');
                return redirect()->intended('/admin')
                    ->withSuccess('Signed in');
            } else {
                if (!is_null(Auth::guard('employer')->user()))
                {
                    Auth::guard('employer')->user()->is_online = 1;
                    Auth::guard('employer')->user()->save();
                }
                if (!is_null(Auth::guard('web')->user()))
                {
                    Auth::guard('web')->user()->is_online = 1;
                    Auth::guard('web')->user()->save();
                }
                return redirect()->intended('/')
                    ->withSuccess('Signed in');
            }

//            return redirect()->intended('/employer/dashboard');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function logout(Request $request)
    {
        /*if (!is_null(Auth::guard('employer')->user()))
        {
            Auth::guard('employer')->user()->is_online = 0;
            Auth::guard('employer')->user()->save();
        }
        if (!is_null(Auth::guard('web')->user()))
        {
            Auth::guard('web')->user()->is_online = 0;
            Auth::guard('web')->user()->save();
        }*/
        Session::flush();

//        Auth::logout();

        return redirect('login');
    }

}
