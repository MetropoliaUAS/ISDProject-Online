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
			<h4>Value in {{$sensor->genericSensor->unit}} / Period: {{$samplings->first()->created_at}} to {{$samplings->last()->created_at}}</h4>
			<div class="ct-chart ct-perfect-fifth" id="chartist_chart"></div>

			<!--Chartist script -->
			<script>
				// Initialize a Line chart in the container with the ID chartX
				var chart_data = {
						labels: [@foreach($samplings as $value) , @endforeach],
						series: [[@foreach($samplings as $value) {{$value->sampled}}, @endforeach]]
					};
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
						showGrid: false,
						// Don't show the label
						showLabel: false
					},
					// Y-Axis specific configuration
					axisY: {
						// Offset from the left to see labels
						offset: 60,
						// Adding units to the values
						labelInterpolationFnc: function(value) {
						  return value + '{{$sensor->genericSensor->unit}}';
						}
					}
				};
				new Chartist.Line('#chartist_chart', chart_data, chart_options);
			</script>
			
			<!--Chartist style -->
			<style>
			.ct-series-a .ct-line {
				stroke-linecap: round;
				/* Set the colour of this series line */
				stroke: teal;
			}

			</style>
            </div>
        </div>
    </div>
@endsection