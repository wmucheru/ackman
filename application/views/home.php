<div class="container">
	
	<?php 
	
		$series = array('EURUSD_2004-2020.json', 'TSLA_2010-2020.json');

		$data = $this->data_model->getJSONData($series[0]);
		$entries = array();

		# var_dump($data);
		foreach($data as $i => $d){
			$d = (object) $d;

			array_push($entries, (object) array(
				'time'=>date('Y-m-d', strtotime($d->Date)),
				'open'=>round($d->Open, 5),
				'high'=>round($d->High, 5),
				'low'=>round($d->Low, 5),
				'close'=>round($d->Price, 5)
			));
		}
	
	?>

	<div id="chart"></div>
</div>
<script type="text/javascript" src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
<script type="text/javascript">
const chart = LightweightCharts.createChart(document.getElementById('chart'), {
	width: window.innerWidth - 50,
	height: 600,
	layout: {
		backgroundColor: '#000000',
		textColor: 'rgba(255, 255, 255, 0.9)',
	},
	grid: {
		vertLines: {
			color: 'rgba(0,0,0,0)',
		},
		horzLines: {
			color: '#222222',
		},
	},
	crosshair: {
		mode: LightweightCharts.CrosshairMode.Normal,
	},
	priceScale: {
		borderColor: 'rgba(197, 203, 206, 0.8)',
	},
	timeScale: {
		borderColor: 'rgba(197, 203, 206, 0.8)',
	}
});
const data = JSON.parse(`<?php echo json_encode($entries) ?>`)
let candleSeries = chart.addCandlestickSeries({
	upColor: 'rgba(255, 144, 0, 1)',
	downColor: '#000',
	borderDownColor: 'rgba(255, 144, 0, 1)',
	borderUpColor: 'rgba(255, 144, 0, 1)',
	wickDownColor: 'rgba(255, 144, 0, 1)',
	wickUpColor: 'rgba(255, 144, 0, 1)',
});

candleSeries.applyOptions({
    priceFormat: {
        type: 'price',
		precision: 4
    }
});

candleSeries.setData(data);
</script>