@extends('layouts.default')

@section('title', '')

@section('content')

    @if(count($AllSensorTypes))
        <div class="container">
            <h2>Registered sensors:</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>alias</th>
                    <th>range</th>
                    <th>producer</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($AllSensorTypes as $sensor)
                    <tr>
                        <td>{{$sensor->id}}</td>
                        <td>{{$sensor->name}}</td>
                        <td>{{$sensor->alias}}</td>
                        <td>{{$sensor->range}}</td>
                        <td>{{$sensor->producer}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif


@endsection