<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function __construct(){
		parent::__construct();
    }
    
    function importCOT(){
        $cot = array('F_TFF_2006_2016.json', 'FinFutYY-2017.json', 'FinFutYY-2018.json', 'FinFutYY-2019.json', 'FinFutYY-2020.json');

        $json = json_decode(file_get_contents(base_url('data/cot/json/'. $cot[0])));
        $data = array();

        foreach($json as $d){
            $d = (object) $d;

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

            if($asset != '-'){
                array_push($data, array(
                    'exchangename'=>$exchange,
                    'asset'=>$asset,
                    'date'=>date('Y-m-d', strtotime($d->Report_Date_as_MM_DD_YYYY)),
                    'levlong'=>$d->Lev_Money_Positions_Long_All,
                    'levshort'=>$d->Lev_Money_Positions_Short_All,
                    'changelevlong'=>$d->Change_in_Lev_Money_Long_All,
                    'changelevshort'=>$d->Change_in_Lev_Money_Short_All,
                    'poichangelevlong'=>$d->Pct_of_OI_Lev_Money_Long_All,
                    'poichangelevshort'=>$d->Pct_of_OI_Lev_Money_Short_All
                ));
            }
        }

        $this->site_model->returnJSON($data);
    }

	/**
	 * 
	 * Homepage: Might show news reports/trends etc
	 * Show session times
	 * 
	*/
	function index(){
		render_page('home', 'Ackman Home', 'home-bd');
	}

	/**
	 * 
	 * Show implied volatility for any asset class(es)
	 * Enable comparison of different assets
	 * 
	*/
	function volatility(){
		render_page('volatility', 'Volatility', 'home-bd');
	}

	/**
	 * 
	 * Active trades, risk/return management
	 * Watchlist: runs cron to show when specific conditions are reached
	 * 
	*/
	function portfolio(){
		render_page('portfolio', 'Volatility', 'home-bd');
	}

	/**
	 * 
	 * Journal of all trades for self-analysis
	 * 
	*/
	function journal(){
		render_page('journal', 'Journal', 'home-bd');
	}
}
