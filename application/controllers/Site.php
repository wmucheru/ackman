<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function __construct(){
		parent::__construct();
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
