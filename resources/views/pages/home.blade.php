@extends('layouts.default')

@section('title', 'Page Title bla')

@section('content')

    <div class="col-md-6 col-md-offset-3">
        <h2>Welcome</h2>
        <p>
            Hey {{ Auth::user()->first_name }},
        </p>
        <p>
            Welcome to our page! If this is your first time logged in,
            you may go to the product section and register the bulb you bought. Afterwards you can check on
            the measured values to get a better understanding of your room climate or gas protection...
        </p>
    </div>

	
	
@endsection