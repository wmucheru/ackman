<div class="container">
	
    <?php 
        $symbol = EURUSD;

		$fx = $this->data_model->getAssetPriceData($symbol);
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

		<?php


			echo form_open('', 'class="form-inline"');

			

			echo form_close();
		?>
    
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#price-chart" data-toggle="tab">Price Chart</a>
            </li>

            <li>
                <a href="#price-table" data-toggle="tab">Price Table</a>
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
            <div class="tab-pane active" id="price-chart">
                <div id="chart"></div>
            </div>

            <div class="tab-pane" id="price-table">
				<?php 
					# var_dump($fx);
					
					if(empty($fx)){
						echo '<div class="alret alert-warning">No FX data available</div>';
					}
					else{
				?>
				<table class="table table-bordered dt">
					<thead>
						<tr>
							<th>Date</th>
							<th>Open</th>
							<th>High</th>
							<th>Low</th>
							<th>Close</th>
							<th>Change</th>
							<th>%Change</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$prevClose = 0;

							foreach($fx as $f){
								$change = $prevClose == 0 ? '-' : $f->close - $prevClose;
								$changePerc = $prevClose == 0 ? '-' : ($change / $prevClose) * 100;
						?>
						<tr>
							<td><?php echo date('Y-m-d', strtotime($f->recordtime)) ?></td>
							<td><?php echo $f->open ?></td>
							<td><?php echo $f->high ?></td>
							<td><?php echo $f->low ?></td>
							<td><?php echo $f->close ?></td>
							<td><?php echo round($change, 4) ?></td>
							<td><?php echo round($changePerc, 2) ?></td>
						</tr>
						<?php
								$prevClose = $f->close; 
							}
						?>
					</tbody>
				</table>

				<hr/>

				<?php
					} # ENDFOR: Show Chart data if available
				?>
            </div>

            <div class="tab-pane" id="cot">
				<?php 
					# var_dump($cot);
					
					if(empty($cot)){
						echo '<div class="alret alert-warning">No COT data available</div>';
					}
					else{
				?>
				<table class="table table-bordered dt">
					<thead>
						<tr>
							<th>Date</th>
							<th>Long</th>
							<th>Short</th>
							<th>Change Long</th>
							<th>Change Short</th>
							<th>%OI Change Long</th>
							<th>%OI Change Short</th>
							<th>%Flip</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($cot as $c){
								$pChangeLong = $c->pclevlong;
								$pChangeShort = $c->pclevshort;

								$flipChange = $pChangeLong - $pChangeShort;
								$flip = $pChangeLong > $pChangeShort ? 
									"<span class=\"label label-success\">$flipChange</span>" : 
									"<span class=\"label label-danger\">$flipChange</span>";
						?>
						<tr>
							<td><?php echo $c->dt ?></td>
							<td><?php echo $c->levlong ?></td>
							<td><?php echo $c->levshort ?></td>
							<td><?php echo $c->clevlong ?></td>
							<td><?php echo $c->clevshort ?></td>
							<td><?php echo $pChangeLong ?></td>
							<td><?php echo $pChangeShort ?></td>
							<td><?php echo $flip ?></td>
							<td><?php echo $c->price ?></td>
						</tr>
						<?php 
							}
						?>
					</tbody>
				</table>

				<hr/>

				<?php
					} # ENDFOR: Show COT data if available
				?>
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
		backgroundColor: '#ffffff',
		textColor: '#000000'
	},
	priceScale: {
		borderColor: 'rgba(197, 203, 206, 1)',
		textColor: '#000000'
	},
	timeScale: {
		borderColor: 'rgba(197, 203, 206, 1)',
	},
	crosshair: {
		mode: LightweightCharts.CrosshairMode.Normal,
	},
	handleScroll: {
        mouseWheel: false,
        pressedMouseMove: true
    },
    handleScale: {
        axisPressedMouseMove: true,
        mouseWheel: false,
        pinch: true
    }
});
const data = JSON.parse(`<?php echo json_encode($entries) ?>`)
let candleSeries = chart.addCandlestickSeries({
	/*upColor: 'rgba(255, 144, 0, 1)',
	downColor: '#000',
	borderDownColor: 'rgba(255, 144, 0, 1)',
	borderUpColor: 'rgba(255, 144, 0, 1)',
	wickDownColor: 'rgba(255, 144, 0, 1)',
	wickUpColor: 'rgba(255, 144, 0, 1)'
	*/
});

candleSeries.applyOptions({
    priceFormat: {
        type: 'price',
		precision: 4
    }
});

candleSeries.setData(data);
</script>