@extends('layouts.default')

@section('title', 'Page Title bla')

@section('content')
    <p>Welcome to our Webapp ISD.</p>
	<p>Please Sign in or <a href="{{ url('/register') }}">REGISTER</a> for a new Account:</p>
	@include('auth/login')
@endsection
