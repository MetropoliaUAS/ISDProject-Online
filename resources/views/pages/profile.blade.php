<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.default')

@section('title', '')

@section('content')

<h2>Your Profile</h2>
{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}

@endsection