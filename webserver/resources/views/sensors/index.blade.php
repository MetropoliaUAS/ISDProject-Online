@extends('layouts.default')

@section('title', '')

@section('content')

    @foreach ($UserSensors as $ProductSensors)
        <div class="container">
            <h2>
                Products:
                <a href="{{url('/products',$ProductSensors->first()->product_id)}}">
                    {{$ProductSensors->first()->product_id}}
                </a>
            </h2>
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
                            <td>
                                <a href="{{url('/sensors/'.$Sensor->id)}}">
                                    {{$Sensor->genericSensor->alias}}
                                </a>
                            </td>
                            {{-- fixme --}}
                            <td>{{count($Sensor->samplings)}}</td>
                            <td>
                                <a href="{{url('/sensors/types/'.$Sensor->generic_sensor_id)}}">
                                    {{$Sensor->generic_sensor_id}} {{$Sensor->genericSensor->name}}
                                </a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection