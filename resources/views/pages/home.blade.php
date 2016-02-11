@extends('layouts.default')

@section('title', 'Page Title bla')

@section('content')

    <p>Hi {{ Auth::user()->first_name }} , This is my body content.</p>
	
	
@endsection