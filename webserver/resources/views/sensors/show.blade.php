@extends('layouts.default')

@section('title', '')

@section('content')

    <h2>Sensor: {{$sensor->id}}</h2>
    <p>Just post a graph, data or whatever here, but dynamically for each sensortype (generic_sensor) or groups of them...eg: boolean vs. float</p>
    @foreach($samplings as $value)
        {{$value->sampled}}  - at - {{$value->created_at}}</br>
    @endforeach
@endsection