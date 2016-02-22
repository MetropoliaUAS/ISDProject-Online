(function ($, Vue) {
    "use strict";

//    var chart_data = {
//        labels: [@foreach($samplings as $value) , @endforeach],
//    series: [[@foreach($samplings as $value) {{$value->sampled}}, @endforeach]]
//};

    function Dashboard () {
        this.products = [];
        this.genericSensorsRepo = new GenericSensorsRepo();
        this.selection = new Selection();

        this.vue = this.createVue();
        this.chart = null;
    }

    Dashboard.prototype.createVue = function () {
        var self = this;

        return new Vue({
            el: '#products',
            data: {
                products: self.products,
                selection: self.selection
            },
            methods: {
                onSensorClick: function (sensor) {
                    dashboard.selection.selectSensor(sensor);
                },
                genericSensorAlias: function (genericSensorId) {
                    var genericSensor = dashboard.genericSensorsRepo.find(genericSensorId);
                    return genericSensor ? genericSensor.alias : "";
                }
            }
        });
    };

    Dashboard.prototype.run = function () {
        var self = this,
            productsUrl = window.location.origin + "/api/products";

        $.getJSON(productsUrl, null, function (data) {
            $.each(data, function (index, item) {
                self.products.push( new Product(item) );
            });
        });

        //this.chart = new Chart();
    };

    Dashboard.prototype.productIdBySensor = function (sensor) {
        var foundProduct = null,
            sensorId = sensor.id || sensor;


        $.each(this.products, function (index, product) {
            $.each(product.sensors, function (index, sensor) {
                if (sensor.id === sensorId) {
                    foundProduct = product;
                    return false;
                }
            });

            if (foundProduct) return false;
        });

        return foundProduct;
    };

    Dashboard.prototype.selectionChange = function () {
        this.getNewSamples();
    };

    Dashboard.prototype.getNewSamples = function () {
        var samplesUrl, requestParams;

        samplesUrl = window.location.origin + "/api/samplings/show/" + this.selection.selectedProductId;
        requestParams = {
            generic_sensor_id: this.selection.selectedGenericSensorId,
            start: "2001-01-01"
        };
        // change second param to have a better filter
        $.getJSON(samplesUrl, requestParams, function (data) {
            console.log(data);
        });
    };

    function Selection () {
        this.selectedSensorId = null;
        this.selectedProductId = null;
        this.selectedGenericSensorId = null;
    }

    Selection.prototype.selectSensor = function (sensor) {
        this.selectedSensorId = sensor.id;
        this.selectedGenericSensorId = sensor.generic_sensor_id;
        this.selectedProductId = dashboard.productIdBySensor(sensor).id;

        dashboard.selectionChange();
    };

    function Product (raw) {
        var self = this;

        this.id = raw.id;
        this.sensors = [];

        $.each(raw.sensors, function (index, rawSensor) {
            self.sensors.push( new Sensor(rawSensor) );
        });
    }

    function Sensor (raw) {
        this.id = raw.id;
        this.generic_sensor_id = raw.generic_sensor_id;
        this.generic_sensor = dashboard.genericSensorsRepo.findOrCreateFromRaw(raw.generic_sensor);
    }

    function GenericSensor (raw) {
        this.id = raw.id;
        this.unit = raw.unit;
        this.alias = raw.alias;
        this.symbol = raw.symbol;
        this.unit = raw.unit;
    }

    // used to not duplicate object for nothing
    function GenericSensorsRepo () {
        this.genericSensors = {};
    }

    GenericSensorsRepo.prototype.findOrCreateFromRaw = function (raw) {
        if (this.genericSensors[raw.id]) return this.genericSensors[raw.id];

        var newGenericSensor = new GenericSensor(raw);
        this.genericSensors[newGenericSensor.id] = newGenericSensor;
        return newGenericSensor;
    };

    GenericSensorsRepo.prototype.find = function (id) {
        return this.genericSensors[id];
    };

    function Chart () {
        var chart_options = {
            fullWidth: true,
            showArea: false,
            // No interpolation
            lineSmooth: false,
            // Don't draw the line chart points
            showPoint: false,
            // X-Axis specific configuration
            axisX: {
                // Disable the grid for this axis
                showGrid: false
            },
            // Y-Axis specific configuration
            axisY: {
                // Offset from the left to see labels
                offset: 40
                // Adding units to the values
                //labelInterpolationFnc: function(value) {
                //    return value + '{{$sensor->genericSensor->unit}}';
                //}
            }
        };
        this.chart = new Chartist.Line('#chartist_chart', null, chart_options);
    }

    Chart.prototype.update = function (newData) {
        this.chart.update(newData);
    };

    $(document).on("ready", function () {
        window.dashboard = new Dashboard();
        dashboard.run();
    });
})(jQuery, Vue);