<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# FX
define('EURUSD', 'eurusd');
define('GBPUSD', 'gbpusd');
define('AUDUSD', 'audusd');
define('NZDUSD', 'nzdusd');
define('USDCAD', 'usdcad');
define('USDCHF', 'usdchf');
define('USDJPY', 'usdjpy');
define('EURJPY', 'eurjpy');
define('EURGBP', 'eurgbp');
define('USDRUB', 'usdrub');
define('USDZAR', 'usdzar');
define('USDBRL', 'usdbrl');
define('USDMXN', 'usdmxn');

define('VIX', 'vix');
define('DXY', 'dxy');

# Stocks / Indices
define('DJI', 'dji');
define('DJIA', 'djia');
define('DJUSRE', 'djusre');
define('SPX', 'spx');
define('NDX', 'ndx');
define('NQ1', 'nq1!');
define('RTYM20', 'rtym20');
define('NI225', 'ni225');

# Bonds
define('US10Y', 'us10y');


class Data_model extends CI_Model{

	public function __construct(){
        parent::__construct();
    }

    function getJSONData($fileName){
        $json = file_get_contents(base_url('data/json/'. $fileName));
        $data = json_decode($json, true);

        return $data;
    }

    /**
     * 
     * https://www.alphavantage.co/support/#api-key
     * 
    */
    function getAlphaAdvantageData(){
        $apiKey = '0U2U2QDSM6MM8O7J';
        $url = "https://www.alphavantage.co/query?function=FX_DAILY&from_symbol=EUR&to_symbol=USD&apikey=$apiKey";

        return $this->site_model->makeCURLRequest('GET', $url);
    }

    /**
     * 
     * https://www.quandl.com/data/CFTC-Commodity-Futures-Trading-Commission-Reports/documentation
     * 
    */
    function getQuandlData(){
        $apiKey = 'yXkDQFZwwczSUT9boGoJ';
        $url = "https://www.quandl.com/data/CFTC?apikey=$apiKey";

        return $this->site_model->makeCURLRequest('GET', $url);
    }
}