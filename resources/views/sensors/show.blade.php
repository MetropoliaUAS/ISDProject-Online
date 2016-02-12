@extends('layouts.default')

@section('title', '')

@section('content')

{!! Form::open() !!}
    <div class="container">
        <h2>{{$sensor->genericSensor->alias}} Sensor</h2>
        <div class="form-group">
            {{ Form::select('age', [
            '1' => 'last hour',
            '6' => 'last 6 hours',
            '24' => 'last 24 hours']
            ) }}
            {!! Form::submit('Update',['class'=>'btn btn-primary form-control']) !!}
        </div>
    </div>
{!! Form::close() !!}


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
      google.charts.load('current', {'packages':['corechart']});
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
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
@endsection