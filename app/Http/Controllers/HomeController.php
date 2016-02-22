<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Location;
use App\Product;
use Illuminate\Foundation\Auth\User;
use phpDocumentor\Reflection\DocBlock\Type\Collection;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CheckAuth()
    {
        return Auth::check();
    }

    public function home()
    {
        return view('pages.home');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function dashboard () {
        return view('pages.dashboard');
    }

}
