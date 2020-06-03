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
}