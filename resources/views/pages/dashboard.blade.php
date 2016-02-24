@extends('layouts.default')

@section('title', 'Dashboard')

@section('jslib')
    <script src="{{ asset("js/vendor.js") }}"></script>
    <script src="{{ asset("js/dashboard.js") }}"></script>
@endsection

@section('content')
    <div id="dashboard-wrapper">
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
            <div class="center-wrapper">
                <div class="time-filters btn-group">
                    <button role="button"
                            class="btn btn-primary"
                            data-time-filter="hour"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'hour' }"
                    >
                        Last hour
                    </button>
                    <button role="button"
                            class="btn btn-primary"
                            data-time-filter="today"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'today' }"
                    >
                        Today
                    </button>
                    <button role="button"
                            class="btn btn-primary"
                            data-time-filter="yesterday"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'yesterday' }"
                    >
                        Yesterday
                    </button>
                    <button role="button"
                            class="btn btn-primary disabled"
                            data-time-filter="week"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'week' }"
                    >
                        Last week
                    </button>
                    <button role="button"
                            class="btn btn-primary" disabled
                            data-time-filter="month"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'month' }"
                    >
                        Last month
                    </button>
                    <button role="button"
                            class="btn btn-primary disabled"
                            data-time-filter="year"
                            v-on:click.prevent="onTimeFilterClick"
                            v-bind:class="{ active: selection.timeFilter === 'year' }"
                    >
                        Last year
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

