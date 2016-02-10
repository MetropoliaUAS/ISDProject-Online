@extends('layouts.default')

@section('title', '')

@section('content')

    <div class="container">
        <h2>Sensor Overview</h2>
        @if(!count($UserSensors))
            <p>
                Sorry, so far you have not bind a product to your account,
                thus there are no sensors to show. Please add a product first.
            </p>
        @endif
        @foreach ($UserSensors as $ProductSensors)
            <h3>Product <a href="{{url('/products',$ProductSensors->first()->product_id)}}">{{$ProductSensors->first()->product_id}}</a> </h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Sensor</th>
                    <th>Sampling Numbers</th>
                    <th>Sensor Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ProductSensors as $Sensor)
                        <tr>
                            <td><a href="{{url('/sensors/'.$Sensor->id)}}">{{$Sensor->genericSensor->alias}}</a></td>
                            <td>{{count($Sensor->samplings)}}</td>
                            <td><a href="{{url('/sensors/types/'.$Sensor->generic_sensor_id)}}">{{$Sensor->generic_sensor_id}} {{$Sensor->genericSensor->name}}</a></td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
@endsection