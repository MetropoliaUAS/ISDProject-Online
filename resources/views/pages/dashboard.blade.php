@extends('layouts.default')

@section('title', 'Dashboard')

@section('jslib')
    <script src="{{ asset("js/vendor.js") }}"></script>
    <script src="{{ asset("js/dashboard.js") }}"></script>
@endsection

@section('content')
    <div id="products" class="col-md-12">
        <ul>
            <li class="product-item" v-for="product in products">
                <h4>@{{ product.id }}</h4>
                <ul>
                    <li class="sensor-item" v-for="sensor in product.sensors">
                        <a href="#"
                           class="btn"
                           data-product-id="@{{ product.id }}"
                           data-sensor-id="@{{ sensor.id }}"
                           data-generic-sensor-id="@{{ sensor.generic_sensor_id }}"
                           v-on:click.prevent="onSensorClick(sensor)"
                           v-bind:class="{ active: selection.selectedSensorId === sensor.id }"
                        >
                            @{{ genericSensorAlias(sensor.generic_sensor_id) }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="chart" class="col-md-9">

    </div>
@endsection

