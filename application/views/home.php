<div class="container">
	
    <?php 
        $symbol = EURUSD;

		$fx = $this->data_model->getAssetFXData($symbol);
		$entries = array();

		foreach($fx as $f){

			array_push($entries, array(
				'time'=>$f->recordtime,
				'open'=>round($f->open, 5),
				'high'=>round($f->high, 5),
				'low'=>round($f->low, 5),
				'close'=>round($f->close, 5)
			));
        }
        
        $cot = $this->data_model->getAssetCOTData($symbol);
	
	?>

    <div class="clearfix">
        <h3><?php echo strtoupper($symbol) ?></h3>
    
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#currency" data-toggle="tab">Currency</a>
            </li>

            <li>
                <a href="#cot" data-toggle="tab">COT Analysis</a>
            </li>
            
            <li>
                <a href="#volatility" data-toggle="tab">Volatility</a>
            </li>
            
            <li>
                <a href="#watchlist" data-toggle="tab">Watchlist</a>
            </li>
        </ul>
    
        <div class="tab-content">
            <div class="tab-pane active" id="currency">
                <div id="chart"></div>
            </div>

            <div class="tab-pane" id="cot">
                <?php var_dump($cot) ?>
            </div>

            <div class="tab-pane" id="volatility">
                VOL
            </div>

            <div class="tab-pane" id="watchlist">
                <div class="alert alert-info">
                    No items in watchlist
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
<script type="text/javascript">
const chart = LightweightCharts.createChart(document.getElementById('chart'), {
	width: 1024,
	height: 540,
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