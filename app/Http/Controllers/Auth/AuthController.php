<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins {
        AuthenticatesAndRegistersUsers::sendFailedLoginResponse as traitSendFailedLoginResponse;
        ThrottlesLogins::sendLockoutResponse as traitSendLockoutResponse;
    }
	
	
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax()) return Response::make("Bad credentials", 401);
        return $this->traitSendFailedLoginResponse($request);
    }

    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($request->ajax()) return ""; // return a 200 HTTP code Code
        return redirect()->intended($this->redirectPath()); // copy paste from trait
    }

    protected function sendLockoutResponse(Request $request)
    {
        if ($request->ajax()) return Response::make("Too Many Requests", 429);
        return $this->traitSendLockoutResponse($request);
    }


}
