<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Model Constants
 * 
*/

# Intervals
define('DAILY', 'daily');
define('WEEKLY', 'weekly');
define('MONTHLY', 'monthly');

/**
 * 
 * Tradeable Assets
 * 
*/

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

    function loadFXData($fileName){
        return json_decode(file_get_contents(base_url('data/fx/json/'. $fileName)));
    }

    function loadCOTData($fileName){
        return json_decode(file_get_contents(base_url('data/cot/json/'. $cot[4])));
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

    /**
     * 
     * FOREX
     * 
     * 
    */
    function hasFXEntry($assetId='', $interval='', $recordTime=''){
        return $this->db
            ->select('id')
            ->get_where('ack_assetdata', array(
                'assetid'=>$assetId,
                'interval'=>$interval,
                'recordtime'=>$recordTime
            ))
            ->num_rows() > 0;
    }

    function getFXData($id='', $asset='', $limit=1000){
        $this->db
            ->select('
                d.id, d.interval, d.open, d.high, d.low, d.close, d.recordtime'
            )
            ->from('ack_assetdata d')
            ->join('ack_assets a', 'a.id = d.assetid', 'left')
            ->limit($limit)
            ->order_by('d.id', 'DESC');

        if($id != ''){
            $this->db->where('d.id', $id);
        }

        if($asset != ''){
            $this->db->where('symbol', $asset);
        }

        $q = $this->db->get();

        return $id != '' ? $q->row() : $q->result();
    }

    function getAssetFXData($asset){
        return $this->getFXData('', $asset);
    }

    /**
     * 
     * COT Analysis
     * 
     * 
    */
    function hasCOTEntry($date, $exchange, $asset){
        return $this->db
            ->select('id')
            ->get_where('ack_cot', array(
                'reportdate'=>$date,
                'exchangename'=>$exchange,
                'asset'=>$asset
            ))
            ->num_rows() > 0;
    }

    function addCOTEntry($obj){
        $d = (object) $obj;

        $exchange = $d->Market_and_Exchange_Names;
        $asset = '-';
        $assetId = '';

        # Assign symbol
        switch($exchange){

            case 'EURO FX - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURUSD;
                $assetId = 1;
                break;

            case 'BRITISH POUND STERLING - CHICAGO MERCANTILE EXCHANGE':
                $asset = GBPUSD;
                $assetId = 2;
                break;

            case 'AUSTRALIAN DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = AUDUSD;
                $assetId = 3;
                break;

            case 'NEW ZEALAND DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = NZDUSD;
                $assetId = 4;
                break;

            case 'CANADIAN DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDCAD;
                $assetId = 5;
                break;

            case 'SWISS FRANC - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDCHF;
                $assetId = 6;
                break;

            case 'JAPANESE YEN - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDJPY;
                $assetId = 7;
                break;

            case 'EURO FX/JAPANESE YEN XRATE - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURJPY;
                $assetId = 8;
                break;

            case 'EURO FX/BRITISH POUND XRATE - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURGBP;
                $assetId = 9;
                break;

            case 'RUSSIAN RUBLE - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDRUB;
                $assetId = 10;
                break;

            case 'SOUTH AFRICAN RAND - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDZAR;
                $assetId = 11;
                break;

            case 'BRAZILIAN REAL - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDBRL;
                $assetId = 12;
                break;

            case 'MEXICAN PESO - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDMXN;
                $assetId = 13;
                break;

            case 'U.S. DOLLAR INDEX - ICE FUTURES U.S.':
                $asset = DXY;
                $assetId = 14;
                break;

            case 'VIX FUTURES - CBOE FUTURES EXCHANGE':
                $asset = VIX;
                $assetId = 15;
                break;

            case 'DJIA Consolidated - CHICAGO BOARD OF TRADE':
                $asset = DJI;
                $assetId = 16;
                break;

            case 'DOW JONES INDUSTRIAL AVG- x $5 - CHICAGO BOARD OF TRADE':
                $asset = DJIA;
                $assetId = 17;
                break;

            case 'DOW JONES U.S. REAL ESTATE IDX - CHICAGO BOARD OF TRADE':
                $asset = DJUSRE;
                $assetId = 18;
                break;

            case 'S&P 500 STOCK INDEX - CHICAGO MERCANTILE EXCHANGE':
                $asset = SPX;
                $assetId = 19;
                break;

            case 'NASDAQ-100 Consolidated - CHICAGO MERCANTILE EXCHANGE':
                $asset = NDX;
                $assetId = 20;
                break;

            case 'NASDAQ-100 STOCK INDEX (MINI) - CHICAGO MERCANTILE EXCHANGE':
                $asset = NQ1;
                $assetId = 21;
                break;

            case 'E-MINI RUSSELL 2000 INDEX - CHICAGO MERCANTILE EXCHANGE':
                $asset = RTYM20;
                $assetId = 22;
                break;

            case 'NIKKEI STOCK AVERAGE - CHICAGO MERCANTILE EXCHANGE':
                $asset = NI225;
                $assetId = 23;
                break;
        }

        $entry = array(
            'exchangename'=>$exchange,
            'asset'=>$asset,
            'reportdate'=>date('Y-m-d', strtotime($d->Report_Date_as_MM_DD_YYYY)),
            'levlong'=>$d->Lev_Money_Positions_Long_All,
            'levshort'=>$d->Lev_Money_Positions_Short_All,
            'changelevlong'=>$d->Change_in_Lev_Money_Long_All,
            'changelevshort'=>$d->Change_in_Lev_Money_Short_All,
            'poichangelevlong'=>$d->Pct_of_OI_Lev_Money_Long_All,
            'poichangelevshort'=>$d->Pct_of_OI_Lev_Money_Short_All
        );

        $this->db->insert('ack_cot', $entry);
    }

    /**
     * 
     * Fetch COT data within provided parameters
     * 
    */
    function getCOTData($id='', $asset='', $exchange='', $limit=1000){
        $this->db
            ->select('
                c.id, c.asset, c.reportdate AS dt, c.levlong, c.levshort,
                c.changelevlong AS clevlong, c.changelevshort AS clevshort, 
                c.poichangelevlong AS pclevlong, c.poichangelevshort AS pclevshort,
                
                d.close AS price'
            )
            ->from('ack_cot c')
            ->join('ack_assets a', 'a.symbol = c.asset', 'left')
            ->join('ack_assetdata d', 'd.assetid = a.id', 'left')
            ->where('d.recordtime = c.reportdate')
            ->limit($limit)
            ->order_by('reportdate', 'DESC');

        if($id != ''){
            $this->db->where('c.id', $id);
        }

        if($exchange != ''){
            $this->db->where('c.exchangename', $exchange);
        }

        if($asset != ''){
            $this->db->where('c.asset', $asset);
        }

        $q = $this->db->get();

        return $id != '' ? $q->row() : $q->result();
    }

    function getAssetCOTData($asset, $limit=1000){
        return $this->getCOTData('', $asset, '', $limit);
    }
}