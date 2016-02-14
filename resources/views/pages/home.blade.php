@extends('layouts.default')

@section('title', 'Page Title bla')

@section('content')
<h2>Welcome</h2>
    <p>Hey {{ Auth::user()->first_name }}, welcome to our page! If this is your first time logged in,
        you may go to the product section and register the bulb you bought. Afterwards you can check on
        the measured values to get a better understanding of your room climate or gas protection...</p>
	
	
@endsection