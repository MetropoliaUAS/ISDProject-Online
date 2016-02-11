@extends('layouts.default')

@section('title', '')

@section('content')
<!--
    <h2>Sensor: {{$sensor->id}}</h2>
    <p>Just post a graph, data or whatever here, but dynamically for each sensortype (generic_sensor) or groups of them...eg: boolean vs. float</p>
    @foreach($samplings as $value)
        {{$value->sampled}}  - at - {{$value->created_at}}</br>
    @endforeach
-->	
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