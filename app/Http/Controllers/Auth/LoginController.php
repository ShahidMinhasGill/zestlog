<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

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
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function authenticated(Request $request, $user)
    {
        if (isAdmin($user)) {// do your magic here
            return redirect()->route('dashboard');
        }
        return redirect('/home');
    }

    /**
     * Check custom login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {
        $this->validate($request,['extension' => 'required','mobile_number' => 'required','password' => 'required']);
        $user = User::where(['extension' => $request->input('extension'), 'mobile_number' => $request->input('mobile_number')])->first();
        $message = 'Wrong Credentials!';
        if (!empty($user) && ($user->user_type == 0 || $user->user_type == 1)) {
            if (\Auth::guard()->attempt($this->getCredentials($request))) {
                if (isAdmin($user)) {// do your magic here
                    return redirect()->route('dashboard');
                } else {
                    return redirect('/home');
                }
            }
        } elseif (!empty($user)) {
            $message = 'Please activate your channel on your mobile app first';
        }
        if (!empty($message))
            \Session::flash('wrong_credentials', $message);
        return redirect()->back();
    }

    /**
     * This is used to get credentials
     *
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return [
            'mobile_number' => $request->input('mobile_number'),
            'password' => $request->input('password')
        ];
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function welcomePage()
    {
        return redirect('/');
    }
}
