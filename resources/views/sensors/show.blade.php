@extends('layouts.default')

@section('title', '')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h2>{{$sensor->genericSensor->alias}} Sensor</h2>
                {!! Form::open() !!}
                <div class="form-group">
                    <select class="c-select">
                        <option selected>Open this select menu</option>
                        <option value="1">last hour</option>
                        <option value="6">last 6 hours</option>
                        <option value="24">last 24 hours</option>
                    </select>
                    {!! Form::submit('Update',['class'=>'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-md-12">

            <!--Chartist chart -->
            <div class="ct-chart ct-perfect-fourth" id="chart1"></div>
            <!--Google chart -->
            <div id="curve_chart"></div>

            <!--Chartist script -->
            <script>
                // Initialize a Line chart in the container with the ID chartX
                var data1 = {
                    labels: [@foreach($samplings as $value) , @endforeach],
                    series: [[@foreach($samplings as $value) {{$value->sampled}}, @endforeach]]
                };
                new Chartist.Line('#chart1', data1);
            </script>

            <!--Google script -->
            <script type="text/javascript">
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['DateTime', 'Value'],
                            @foreach($samplings as $value)
                        [,  {{$value->sampled}}],
                        @endforeach
                    ]);

                    var options = {
                        title: 'Measurement',
                        curveType: 'function',
                        legend: {position: 'bottom'}
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                    chart.draw(data, options);
                }
            </script>
            </div>
        </div>
    </div>
@endsection