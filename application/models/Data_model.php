<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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