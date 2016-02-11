<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
    public function index()
    {
        return view('pages.welcome');
	}
	
	public function about()
    {
        return view('pages.about');
    }
	
	public function register()
    {
        return view('pages.register');
    }
	
	public function resetpassword()
    {
		return view('pages.resetpassword');
    }
	
	
}
