<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated($request, $user )
    {
        if (session()->has('last_page')) {
//            return Redirect::to($url);
            $page = session('last_page');
            return redirect()->to($page);
        } else{
            return redirect()->route('/');
        }
//        return redirect()->intended($this->redirectPath());
    }

//    public function logout(Request $request)
//    {
//        $this->performLogout($request);
//        if (session()->has('last_page')) {
////            return Redirect::to($url);
//            return redirect()->to(session('last_page'));
//        } else{
//            return redirect()->route('story');
//        }
//    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        if (session()->has('last_page')) {
//            return Redirect::to($url);
            $page = session('last_page');
            return redirect()->to($page);
        } else{
            return redirect()->route('/');
        }
    }
}
