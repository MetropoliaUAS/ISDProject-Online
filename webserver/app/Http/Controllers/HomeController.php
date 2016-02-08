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
     *
     * @return void
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
		$name ='alf';
        return view('pages.home')->with('name');
	}
	
	public function profile()
    {
        $name ='alf';
        return view('pages.profile')->with([
		'first_name' => 'Marc',
		'last_name' => 'Bolder'
		]);
    }
	
	public function measurements()
    {
        return view('pages.measurements');
    }

}
