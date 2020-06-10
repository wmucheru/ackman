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

        # Assign symbol
        switch($exchange){

            case 'EURO FX - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURUSD;
                break;

            case 'BRITISH POUND STERLING - CHICAGO MERCANTILE EXCHANGE':
                $asset = GBPUSD;
                break;

            case 'AUSTRALIAN DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = AUDUSD;
                break;

            case 'NEW ZEALAND DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = NZDUSD;
                break;

            case 'CANADIAN DOLLAR - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDCAD;
                break;

            case 'SWISS FRANC - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDCHF;
                break;

            case 'JAPANESE YEN - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDJPY;
                break;

            case 'EURO FX/JAPANESE YEN XRATE - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURJPY;
                break;

            case 'EURO FX/BRITISH POUND XRATE - CHICAGO MERCANTILE EXCHANGE':
                $asset = EURGBP;
                break;

            case 'RUSSIAN RUBLE - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDRUB;
                break;

            case 'SOUTH AFRICAN RAND - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDZAR;
                break;

            case 'BRAZILIAN REAL - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDBRL;
                break;

            case 'MEXICAN PESO - CHICAGO MERCANTILE EXCHANGE':
                $asset = USDMXN;
                break;

            case 'DJIA Consolidated - CHICAGO BOARD OF TRADE':
                $asset = DJI;
                break;

            case 'DOW JONES INDUSTRIAL AVG- x $5 - CHICAGO BOARD OF TRADE':
                $asset = DJIA;
                break;

            case 'DOW JONES U.S. REAL ESTATE IDX - CHICAGO BOARD OF TRADE':
                $asset = DJUSRE;
                break;

            case 'S&P 500 STOCK INDEX - CHICAGO MERCANTILE EXCHANGE':
                $asset = SPX;
                break;

            case 'NASDAQ-100 Consolidated - CHICAGO MERCANTILE EXCHANGE':
                $asset = NDX;
                break;

            case 'NASDAQ-100 STOCK INDEX (MINI) - CHICAGO MERCANTILE EXCHANGE':
                $asset = NQ1;
                break;

            case 'E-MINI RUSSELL 2000 INDEX - CHICAGO MERCANTILE EXCHANGE':
                $asset = RTYM20;
                break;

            case 'NIKKEI STOCK AVERAGE - CHICAGO MERCANTILE EXCHANGE':
                $asset = NI225;
                break;

            case 'U.S. DOLLAR INDEX - ICE FUTURES U.S.':
                $asset = DXY;
                break;

            case 'VIX FUTURES - CBOE FUTURES EXCHANGE':
                $asset = VIX;
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
                id, asset, reportdate AS dt, levlong, levshort,
                changelevlong AS clevlong, changelevshort AS clevshort, 
                poichangelevlong AS pclevlong, poichangelevshort AS pclevshort'
            )
            ->from('ack_cot')
            ->limit($limit)
            ->order_by('id', 'DESC');

        if($id != ''){
            $this->db->where('id', $id);
        }

        if($exchange != ''){
            $this->db->where('exchangename', $exchange);
        }

        if($asset != ''){
            $this->db->where('asset', $asset);
        }

        $q = $this->db->get();

        return $id != '' ? $q->row() : $q->result();
    }

    function getAssetCOTData($asset, $limit=''){
        return $this->getCOTData('', $asset, '', $limit);
    }
}