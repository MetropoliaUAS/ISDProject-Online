@extends('layouts.default')

@section('title', '')

@section('content')

    <div class="container">
        @foreach($userSensorsByProductIds as $productId => $userSensors)
            <div class="product-item">
                <header>
                    <h2>
                        Product:
                        <a href="{{ url('/products', $productId) }}">
                            {{ $productId }}
                        </a>
                    </h2>
                </header>
                <article>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sensor</th>
                                <th>Sampling Numbers</th>
                                <th>Sensor Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userSensors as $sensor)
                                <tr>
                                    <td>
                                        <a href="{{url('/sensors', $sensor->id)}}">
                                            {{$sensor->genericSensor->alias}}
                                        </a>
                                    </td>
                                    {{-- fixme --}}
                                    <td>{{count($sensor->samplings)}}</td>
                                    <td>
                                        <a href="{{url('/sensors/types', $sensor->generic_sensor_id)}}">
                                            {{$sensor->generic_sensor_id}} {{$sensor->genericSensor->name}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </article>
            </div>
        @endforeach
    </div>
@endsection