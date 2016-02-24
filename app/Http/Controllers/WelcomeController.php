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
        $this->middleware('guest', [ 'except' => 'about' ]);
    }
	
    public function index()
    {
        return view('pages.welcome');
	}
	
	public function about()
    {
        return view('pages.about');
    }
}
