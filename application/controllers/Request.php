<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "ilaclar_v";
		
		$this->load->model("ilaclar_model");
		
        if(!get_active_user()){
            redirect(base_url("login"));
        }

    }

    public function index()
	{
		
		$istendi = 0;
		
		$expired_and_stockout = $this->ilaclar_model->get_expired_and_stockout($istendi);
		
		$viewData = new stdClass();
		
		$viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "ilac_iste";
        $viewData->frontViewFolder = "admin";
        $viewData->expired_and_stockout = $expired_and_stockout;

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
		
	}
	
	public function ilaclari_iste(){

		
		$stockout_ilaclar = $this->ilaclar_model->get_stockout();
		$expired_ilaclar = $this->ilaclar_model->get_expired();
		
		foreach($stockout_ilaclar as $stockout_ilac){
			
			$update = $this->ilaclar_model->update(
				array("id" => $stockout_ilac->id),
				array(
					"istendi" => 1
				)
			);	
		}
		
		foreach($expired_ilaclar as $expired_ilac){
			
			$update = $this->ilaclar_model->update(
				array("id" => $expired_ilac->id),
				array(
					"istendi" => 1
				)
			);	
		}
		
		redirect(base_url("ilaclar/ilac-iste"));

	}
}
