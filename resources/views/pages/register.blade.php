@extends('layouts.default')

@section('title', 'Page Title bla')

@section('content')
<p>Please insert your personal data to create a new Account:</p>    
	@include('auth/register')
@endsection
