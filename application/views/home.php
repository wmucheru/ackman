<div class="container">
	
	<?php 
	
		$tesla = 'TSLA_2010-2020.json';

		$data = $this->data_model->getJSONData($tesla);

		# var_dump($data);
	
	?>

	<div id="chart_div" style="width: 900px; height: 500px;"></div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Mon', 20, 28, 38, 45],
		['Tue', 31, 38, 55, 66],
		['Wed', 50, 55, 77, 80],
		['Thu', 77, 77, 66, 50],
		['Fri', 68, 66, 22, 15]
	], true);

	var options = {
		legend: 'none',
		// bar: { groupWidth: '100%' }, // Remove space between bars.
		// candlestick: {
		// 	fallingColor: { strokeWidth: 0, fill: '#a52714' }, // red
		// 	risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
		// }
	};

	var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}
</script>