(function ($, Vue, Chartist) {
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

        this.chart = new Chart();
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
        var self = this,
            samplesUrl, requestParams;

        samplesUrl = window.location.origin + "/api/samplings/show/" + this.selection.selectedProductId;
        requestParams = {
            generic_sensor_id: this.selection.selectedGenericSensorId,
            start: "2001-01-01",
            limit: 10
        };
        // change second param to have a better filter
        $.getJSON(samplesUrl, requestParams, function (data) {
            self.chart.update( new GraphData(data) );
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
        this.range = {
            low: raw.range.split('-')[0],
            high: raw.range.split('-')[1]
        };
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
            height: 500,

            showArea: false,
            showPoint: false,
            chartPadding: {
                right: 40
            },
            axisX: {
                showGrid: false
            }
        };
        this.chart = new Chartist.Line('#chart', null, chart_options);
    }

    Chart.prototype.buildNewOpts = function () {
        var sensorUnit;

        sensorUnit = dashboard.genericSensorsRepo.find(
            dashboard.selection.selectedGenericSensorId
        ).unit;

        return {
            axisX: {
                labelInterpolationFnc: function (value, index, data) {
                    var modulus = Math.round(data.length / 15);

                    if (modulus == 0) return value;
                    return index % modulus === 0 ? value : '';
                }
            },
            axisY: {
                // Adding units to the values
                labelInterpolationFnc: function(value) {
                    return value + " " + sensorUnit;
                }
            }
        }
    };

    Chart.prototype.update = function (graphData) {
        var newData = graphData.getData(),
            newOpts = this.buildNewOpts();

        // We have to fix it, since chartist has an error if we have only 1 value.
        // So the workaround is to duplicate the labels and value
        if (graphData.count() == 1) {
            newData = this.fixNewData(newData);
        }
        this.chart.update(newData, newOpts, true);
    };

    Chart.prototype.fixNewData = function (newData) {
        newData.labels.push(newData.labels[0]);
        newData.series[0].push(newData.series[0][0]);
        return newData;
    };

    function GraphData (raw) {
        var self = this;

        self.labels = [];
        self.serie = [];

        $.each(raw, function (index, rawSample) {
            self.labels.push(rawSample.created_at);
            self.serie.push(rawSample.sampled);
        });
    }

    GraphData.prototype.getData = function () {
        return {
            labels: this.labels,
            series: [this.serie]
        };
    };

    GraphData.prototype.count = function () {
        return this.serie.length;
    };

    $(document).on("ready", function () {
        window.dashboard = new Dashboard();
        dashboard.run();
    });
})(jQuery, Vue, Chartist);
//# sourceMappingURL=dashboard.js.map
