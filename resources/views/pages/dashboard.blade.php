@extends('layouts.default')

@section('title', 'Dashboard')

@section('jslib')
    <script src="{{ asset("js/vendor.js") }}"></script>
    <script src="{{ asset("js/dashboard.js") }}"></script>
@endsection

@section('content')
    <div id="products" class="col-md-3">
        <ul class="products-list">
            <li class="product-item" v-for="product in products">
                <h4>@{{ product.id }}</h4>
                <ul class="sensors-list">
                    <li class="sensor-item"
                        v-for="sensor in product.sensors"
                        v-on:click.prevent="onSensorClick(sensor)"
                        v-bind:class="{ active: selection.selectedSensorId === sensor.id }"
                    >
                        <a href="#">
                            @{{ genericSensorAlias(sensor.generic_sensor_id) }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-md-9">
        <div id="chart"></div>
    </div>
@endsection

