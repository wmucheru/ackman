<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function __construct(){
		parent::__construct();
    }
    
    function importCOT(){
        /*
        $cot = array(
            'F_TFF_2006_2016.json', 
            'FinFutYY-2017.json', 
            'FinFutYY-2018.json', 
            'FinFutYY-2019.json', 
            'FinFutYY-2020.json'
        );

        $json = json_decode(file_get_contents(base_url('data/cot/json/'. $cot[4])));

        foreach($json as $d){
            $this->data_model->addCOTEntry($d);
        }
        */

        $cot = $this->data_model->getAssetCOTData('vix', 20);

        $this->site_model->returnJSON($cot);
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
