<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Europe/Istanbul');

class Dashboard extends CI_Controller {

    public $viewFolder = "";
	

    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "dashboard_v";
		
		$this->load->model("ilaclar_model");
		$this->load->model("user_model");
		$this->load->model("siparisler_model");
		
        if(!get_active_user()){
            redirect(base_url("login"));
        }

    }

    public function index($aylik_tablo_yili="")
	{
		
		if ($aylik_tablo_yili == ""){
			$aylik_tablo_yili = date('Y');
		}
	
		$viewData = new stdClass();
        $viewData->viewFolder             = $this->viewFolder;
        $viewData->frontViewFolder        = "admin";
	
		$now                    = date('Y-m-d H:i:s');
		$today_start_time 		= date('Y-m-d 00:00:00');
		$yesterday_start_time   = date('Y-m-d 00:00:00', strtotime("-1 days"));
		$yesterday_end_time     = date('Y-m-d 23:59:59', strtotime("-1 days"));
		$last_week              = date('Y-m-d H:i:s', strtotime("-7 days"));
		$this_month             = date('m');
		$last_month             = date('m', strtotime("-1 month"));
		$this_year              = date('Y');
		$last_year              = date('Y', strtotime("-1 year"));
		$this_year_first_day    = date('Y-01-01');
		$last_year_first_day    = date('Y-01-01', strtotime("-1 year"));
		$last_year_last_day     = date('Y-12-31', strtotime("-1 year"));
		
		
		//GÜNLÜK SATIŞ
		$gunluk_satislar = $this->siparisler_model->tarihler_arasi($today_start_time, $now);
		$gunluk_toplam_satis = 0;
		foreach($gunluk_satislar as $gunluk_satis){
			$gunluk_toplam_satis += $gunluk_satis->toplam_fiyat;
		}
		
		$dunku_satislar = $this->siparisler_model->tarihler_arasi($yesterday_start_time, $yesterday_end_time);
		$dunku_toplam_satis = 0;
		foreach($dunku_satislar as $dunku_satis){
			$dunku_toplam_satis += $dunku_satis->toplam_fiyat;
		}
		
		$viewData->gunluk_satis = $gunluk_toplam_satis;
		
		$gunluk_toplam_satis++;
		$dunku_toplam_satis++;
		$dune_gore_fark = round(($gunluk_toplam_satis - $dunku_toplam_satis)*100/$dunku_toplam_satis, 2);
		
		$viewData->dune_gore_fark = $dune_gore_fark;
		
		
		//HAFTALIK SATIŞ
		$haftalik_satislar = $this->siparisler_model->tarihler_arasi($last_week, $now);
		$haftalik_toplam_satis = 0 ;
		foreach($haftalik_satislar as $haftalik_satis){
			$haftalik_toplam_satis += $haftalik_satis->toplam_fiyat;
		}
		
		$onceki_hafta_satislar = $this->siparisler_model->tarihler_arasi(date('Y-m-d H:i:s', strtotime("-14 days")), $last_week);
		$onceki_hafta_toplam_satis = 0;
		foreach($onceki_hafta_satislar as $onceki_hafta_satis){
			$onceki_hafta_toplam_satis += $onceki_hafta_satis->toplam_fiyat;
		}
		
		$viewData->haftalik_satis = $haftalik_toplam_satis;
		
		$haftalik_toplam_satis++;
		$onceki_hafta_toplam_satis++;
		$onceki_haftaya_gore_fark = round(($haftalik_toplam_satis - $onceki_hafta_toplam_satis)*100/$onceki_hafta_toplam_satis, 2);
		
		$viewData->onceki_haftaya_gore_fark = $onceki_haftaya_gore_fark;

		
		//AYLIK SATIŞ
		$aylik_satislar = $this->siparisler_model->get_month($this_month, $this_year);
		$aylik_toplam_satis = 0;
		foreach($aylik_satislar as $aylik_satis){
			$aylik_toplam_satis += $aylik_satis->toplam_fiyat;
		}
		
		
		if($last_month == 12){
			$this_year = date('Y', strtotime("-1 year"));
		}
		
		$onceki_ay_satislar = $this->siparisler_model->get_month($last_month, $this_year);
		
		$onceki_ay_toplam_satis = 0;
		foreach($onceki_ay_satislar as $onceki_ay_satis){
			$onceki_ay_toplam_satis += $onceki_ay_satis->toplam_fiyat;
		}
		
		$viewData->aylik_satis = $aylik_toplam_satis;
		
		$aylik_toplam_satis++;
		$onceki_ay_toplam_satis++;
		$onceki_aya_gore_fark = round(($aylik_toplam_satis - $onceki_ay_toplam_satis)*100/$onceki_ay_toplam_satis, 2);
		
		$viewData->onceki_aya_gore_fark = $onceki_aya_gore_fark;
		
		//YILLIK SATIŞ
		$yillik_satislar = $this->siparisler_model->tarihler_arasi($this_year_first_day, $now);
		$yillik_toplam_satis = 0;
		foreach($yillik_satislar as $yillik_satis){
			$yillik_toplam_satis += $yillik_satis->toplam_fiyat;
		}
		
		$onceki_yil_satislar = $this->siparisler_model->tarihler_arasi($last_year_first_day, $last_year_last_day);
		$onceki_yil_toplam_satis = 0;
		foreach($onceki_yil_satislar as $onceki_yil_satis){
			$onceki_yil_toplam_satis += $onceki_yil_satis->toplam_fiyat;
		}
		
		$viewData->yillik_satis = $yillik_toplam_satis;
		
		$yillik_toplam_satis++;
		$onceki_yil_toplam_satis++;
		$onceki_yila_gore_fark = round(($yillik_toplam_satis - $onceki_yil_toplam_satis)*100/$onceki_yil_toplam_satis, 2);
		
		
		$viewData->onceki_yila_gore_fark = $onceki_yila_gore_fark;		
		
		
		$year = date("Y");
		$month = date("m");
		
		$eczacilar_aylik_satis = array();
		
		$eczacilar = $this->user_model->get_all(
			array(),
		);
		
		foreach($eczacilar as $eczaci){
			
			$eczaci_aylik_satis = array();
			
			$eczaci_satis = 0;
			$satislar = $this->siparisler_model->ayin_elemani($month, $year, $eczaci->user_name);
			
			if($satislar != ""){
				foreach($satislar as $satis){
					
					$eczaci_satis += $satis->toplam_fiyat;
					
				}
			}else{
				$eczaci_satis = 0;
			}
			
			$eczaci_aylik_satis = array(
			
				$eczaci->user_name => $eczaci_satis
				
			);
			
			array_push($eczacilar_aylik_satis, $eczaci_aylik_satis);
		}
		
		$yillik_satislar = array();
		
		for($i=1; $i < 13; $i++){
			
			$aylik_toplam = 0;
			$aylik = $this->siparisler_model->get_month($i, $aylik_tablo_yili);
			
			foreach($aylik as $item){
				$aylik_toplam += $item->toplam_fiyat;
			}
			
			array_push($yillik_satislar, $aylik_toplam);
		}
		
		$ilk_siparis = $this->siparisler_model->get_first_row();	
		$ilk_siparis_yili = new DateTime($ilk_siparis[0]->siparis_tarihi);
		
	
		$viewData->ilk_siparis_yili       = $ilk_siparis_yili->format('Y');
        $viewData->yillik_satislar        = $yillik_satislar;
        $viewData->eczacilar              = $eczacilar;
        $viewData->eczacilar_aylik_satis  = $eczacilar_aylik_satis;
		
		$this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/index", $viewData);
		
	}
}