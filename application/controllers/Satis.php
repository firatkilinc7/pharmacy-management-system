<?php

class Satis extends CI_Controller
{
    public $viewFolder = "";

    public function __construct()
    {

        parent::__construct();

        $this->viewFolder = "satis_v";

        $this->load->model("sepet_model");
        $this->load->model("ilaclar_model");
        $this->load->model("siparisler_model");

        if(!get_active_user()){
            redirect(base_url("login"));
        }

    }

    public function index(){

		$this->load->library("cart");
	
        $viewData = new stdClass();

        $ilaclar = $this->ilaclar_model->get_all(
            array(),
        );

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->frontViewFolder = "admin";
        $viewData->ilaclar = $ilaclar;

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }


	public function filtrele(){

		$viewData = new stdClass();
		
		if(null !== $this->input->post("barkod") and null == $this->input->post("ilac_adi")){
			//sadece barkod ile filtreleme
			$ilaclar = $this->ilaclar_model->string_search($this->input->post("barkod"), "barkod");
			$viewData->barkod = $this->input->post("barkod");
			
		}else if(null == $this->input->post("barkod") and null !== $this->input->post("ilac_adi")){
			//sadece ilac adi ile filtreleme
			$ilaclar = $this->ilaclar_model->string_search($this->input->post("ilac_adi"), "ilac_adi");
			$viewData->ilac_adi = $this->input->post("ilac_adi");
		}else{
			$ilaclar = $this->ilaclar_model->multi_string_search($this->input->post("barkod"), "barkod", $this->input->post("ilac_adi"), "ilac_adi");
			$viewData->ilac_adi = $this->input->post("ilac_adi");
			$viewData->barkod = $this->input->post("barkod");
		}
		
        
		$viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->frontViewFolder = "admin";
        $viewData->ilaclar = $ilaclar;
		

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
		
		
    }

	public function sepete_ekle(){
    
		$ilac = $this->ilaclar_model->get(
			array(
				"id"    => $_POST["id"]
			)
		);
		
		
		$data = array(
		   "id"       => $ilac->id,
		   "barkod"   => $ilac->barkod,
		   "name"     => $ilac->ilac_adi,
		   "price"    => $ilac->ilac_fiyati,
		   "qty"      => $_POST["quantity"]
		);

		$this->load->library("cart");
		$this->cart->insert($data);
	
	}

	public function sepet($sgk_durumu=""){
		
		$this->load->library("cart");
		$viewData = new stdClass();
		
		if($sgk_durumu !== ""){
			$sepet_urunler = $this->cart->contents();
			
			if($sgk_durumu == "0"){
				//SGKSIZ
				
				foreach($sepet_urunler as $urunler){
					
					$ilac = $this->ilaclar_model->get(
						array(
							"id"    => $urunler["id"]
						)
					);
					
					$data = $this->cart->update(array(
						"rowid"  => $urunler["rowid"],
						"price"  => $ilac->ilac_fiyati
					));
					
					$this->cart->update($data); 
				}
				
				
			}else if($sgk_durumu == "1"){
				//SGKLI
				foreach($sepet_urunler as $urunler){
					$ilac = $this->ilaclar_model->get(
						array(
							"id"    => $urunler["id"]
						)
					);
						
					$data = $this->cart->update(array(
						"rowid"  => $urunler["rowid"],
						"price"  => $ilac->indirimli_fiyat
					));
					
					$this->cart->update($data);
				}
				
			}else{
				redirect(base_url("ilaclar"));
			}
		}
		
		$sepet_ilaclar = $this->cart->contents();
		
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "sepet";
        $viewData->frontViewFolder = "admin";
        $viewData->sepet_ilaclar = $sepet_ilaclar;
		$viewData->toplamFiyat = $this->cart->total();
		$viewData->sgkDurumu = $sgk_durumu;
		

		

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
	
	public function sepeti_temizle(){
		
		$this->load->library("cart");
		$this->cart->destroy();
		
		redirect(base_url("satis/sepet"));
	}
	
	public function sepetten_cikar(){
		
		$this->load->library("cart");
		
		$silinecek = $_POST["delete"];
		
		
		$data = array(
			"rowid"  => $silinecek,
			"qty" => 0
		);
		
		$this->cart->update($data);
		
		redirect(base_url("satis/sepet"));
	}

	public function sepeti_onayla(){
		
		$this->load->library("cart");
		$viewData = new stdClass();
		$sepet_urunler = $this->cart->contents();
		
		$siparis_icerikleri = "";
		
		foreach($sepet_urunler as $urunler){
			
			$siparis_icerikleri .= $urunler["name"].", ";
			
		};
		
		$date = date("Y-m-d H:i:s");
		
		$insert = $this->siparisler_model->add(
			array(
				"siparis_icerikleri"   => $siparis_icerikleri,
				"toplam_fiyat"         => $this->cart->total(),
				"eczaci"               => $this->session->userdata('user')->user_name,
				"siparis_tarihi"       => $date
			)
		);
		
		if($insert){
			
			foreach($sepet_urunler as $urunler){
				
				$ilac= $this->ilaclar_model->get(
					array(
						"id"    => $urunler["id"]
					)
				);
				
				$update = $this->ilaclar_model->update(
					array("id" => $urunler["id"]),
					array(
						"stok" => $ilac->stok - $urunler["qty"]
						)
				);
			
			};
			
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "rapor";
			$viewData->frontViewFolder = "admin";
			
			$viewData->siparis_icerikleri = $siparis_icerikleri;
			$viewData->toplam_fiyat = $this->cart->total();
			$viewData->eczaci = get_users_full_name($this->session->userdata('user')->user_name);
			$viewData->siparis_tarihi = $date;
			
			$this->cart->destroy();
			
			$this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
		}
		
	}

}
