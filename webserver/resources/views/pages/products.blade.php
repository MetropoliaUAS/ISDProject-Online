<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.default')

@section('title', '')

@section('content')

<h2> This site is to let the user add/delete a product and view all his products</h2>

@if(count($products))
	<h3>Registered Products:</h3>
	<ul>
	@foreach ($products as $product)
		<li>{{$product->id}} Version {{$product->version}}</li>
	@endforeach
	</ul>
@endif
@endsection