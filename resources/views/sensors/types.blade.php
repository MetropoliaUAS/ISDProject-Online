@extends('layouts.default')

@section('title', '')

@section('content')

    @if(count($AllSensorTypes))
        <div class="container">
            <h2>Registered Sensors:</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Alias</th>
                    <th>Range</th>
					<th>Unit</th>
                    <th>Producer</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($AllSensorTypes as $sensor)
                    @if($sensor->id == $SensorID)
                    <tr bgcolor="red">
                    @else
                    <tr>
                    @endif
                        <td>{{$sensor->id}}</td>
                        <td>{{$sensor->name}}</td>
                        <td>{{$sensor->alias}}</td>
                        <td>{{$sensor->range}}</td>
						<td>{{$sensor->unit}}</td>
                        <td>{{$sensor->producer}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif


@endsection