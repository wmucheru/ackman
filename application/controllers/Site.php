<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function __construct(){
		parent::__construct();
    }
    
    function importCOT(){
        /*
        $data = $this->data_model->loadCOTData('FinFutYY-2020.json');

        foreach($data as $d){
            $this->data_model->addCOTEntry($d);
        }
        */

        $cot = $this->data_model->getAssetCOTData('vix', 20);

        $this->site_model->returnJSON($cot);
    }

    function importFX(){
        /*
        $data = $this->data_model->loadFXData('EURUSD_2004-2020.json');

		foreach($data as $i => $d){
            $d = (object) $d;
            
            $fx = array(
                'assetid'=>1,
                'interval'=>'daily',

				'open'=>round($d->Open, 5),
				'high'=>round($d->High, 5),
				'low'=>round($d->Low, 5),
				'close'=>round($d->Price, 5),
                'recordtime'=>date('Y-m-d', strtotime($d->Date)),
                'createdby'=>1
            );
            
            $this->db->insert('ack_assetdata', $fx);
        }
        */
        
        $fx = $this->data_model->getAssetFXData(EURUSD);

        $this->site_model->returnJSON($fx);
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
