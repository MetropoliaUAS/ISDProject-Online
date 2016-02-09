@extends('layouts.default')

@section('title', '')

@section('content')

    @foreach ($UserProducts as $Product)
        <div class="container">
            <h2>Products: {{$Product->id}}</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Sensor ID</th>
                    <th>Sensor type</th>
                    <th>Product ID</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($UserSensors as $Sensor)
                    @if($Sensor->product_id == $Product->id)
                        <tr>
                            <td><a href="{{url('/sensors/'.$Sensor->id)}}">{{$Sensor->id}}</a></td>
                            <td><a href="{{url('/sensors/types')}}">{{$Sensor->generic_sensor_id}}</a></td>
                            <td><a href="{{url('/products',$Sensor->product_id)}}">{{$Sensor->product_id}}</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection