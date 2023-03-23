<?php

class Ilaclar extends CI_Controller
{
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

    public function index(){

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


    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->frontViewFolder = "admin";

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save(){	
		
		$this->load->library("form_validation");
		
		if($_FILES["img_url"]["name"] == ""){

            $alert = array(
                "title" => "İşlem Başarısız",
                "text"  => "Lütfen ilaç görseli seçiniz",
                "type"  => "error"
            );

            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("ilaclar/new_form"));
            die();
        }
		
        $this->form_validation->set_rules("barkod", "Barkod No", "required|trim|is_unique[ilaclar.barkod]|min_length[8]|max_length[8]");
        $this->form_validation->set_rules("ilac_adi", "İlaç Adı", "required|trim");
        $this->form_validation->set_rules("stok", "Stok Durumu", "required|trim|numeric|greater_than[-1]");
        $this->form_validation->set_rules("sgk_indirim", "SGK İndirim Oranı", "required|trim|numeric|greater_than[-1]|less_than[100]");
        $this->form_validation->set_rules("expired_date", "Son Kullanma Tarihi", "required|trim");
        $this->form_validation->set_rules("ilac_fiyati", "İlaç Fiyatı", "required|trim|numeric|greater_than[-1]");

        $this->form_validation->set_message(
            array(
                "required"            => "<b>{field}</b> alanı doldurulmalıdır",
                "is_unique"           => "<b>{field}</b> numaralı barkod başka ilaca aittir.",
                "min_length"          =>"Barkod numarası mutlaka 8 karakter olmalıdır.",
                "max_length"          =>"Barkod numarası mutlaka 8 karakter olmalıdır.",
                "numeric"  	          =>"<b>{field}</b> alanı sayısal değer içermelidir.",
                "greater_than"        =>"<b>{field}</b>, \"0\" değerine eşit veya büyük olmalıdır.",
                "less_than"           =>"<b>{field}</b>, \"100\" değerinden büyük olmamalıdır.",
            )
        );
		
        $validate = $this->form_validation->run();

        if($validate){

			$file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);
            $image_900x600 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/images/$this->viewFolder",900,600, $file_name);
			
			if($image_900x600){
			
				$insert = $this->ilaclar_model->add(
					array(
						"barkod"           => $this->input->post("barkod"),
						"ilac_adi"         => $this->input->post("ilac_adi"),
						"stok"             => $this->input->post("stok"),
						"sgk_indirim"      => $this->input->post("sgk_indirim"),
						"expired_date"     => $this->input->post("expired_date"),
						"ilac_fiyati"      => $this->input->post("ilac_fiyati"),
						"indirimli_fiyat"  => $this->input->post("indirimli_fiyat"),
						"raf_numarasi"     => $this->input->post("raf_numarasi"),
						"img_url"          => $file_name,
					)
				);
			
				if($insert){

					$alert = array(
						"title" => "İşlem Başarılı",
						"text"  => "İlaç kaydı başarılı bir şekilde eklendi",
						"type"  => "success"
					);

				} else {

					$alert = array(
						"title" => "İşlem Başarısız",
						"text"  => "Kayıt Ekleme sırasında bir problem oluştu",
						"type"  => "error"
					);
				}
			}else{
				
				$alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Görsel yüklenirken bir problem oluştu",
                    "type"  => "error"
                );

                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("ilaclar/new_form"));
                die();
			}
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("ilaclar"));
            die();

        } else {

            $viewData = new stdClass();
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->frontViewFolder = "admin";
            $viewData->form_error = true;

            $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }

    }

    public function update_form($id){

        $viewData = new stdClass();

        $ilac = $this->ilaclar_model->get(
            array(
                "id"    => $id,
            )
        );

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->frontViewFolder = "admin";

        $viewData->ilac = $ilac;
        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }


    public function update($id){

		$this->load->library("form_validation");

		$oldIlac = $this->ilaclar_model->get(
			array(
				"id"    => $id
			)
		);

		if(!$oldIlac->barkod == $this->input->post("barkod")){
			$this->form_validation->set_rules("barkod", "Barkod No", "required|trim|is_unique[ilaclar.barkod]|min_length[8]|max_length[8]");
		}
		
        $this->form_validation->set_rules("ilac_adi", "İlaç Adı", "required|trim");
        $this->form_validation->set_rules("stok", "Stok Durumu", "required|trim|numeric|greater_than[-1]");
        $this->form_validation->set_rules("sgk_indirim", "SGK İndirim Oranı", "required|trim|numeric|greater_than[-1]|less_than[100]");
        $this->form_validation->set_rules("expired_date", "Son Kullanma Tarihi", "required|trim");
		$this->form_validation->set_rules("ilac_fiyati", "İlaç Fiyatı", "required|trim|numeric|greater_than[-1]");

        $this->form_validation->set_message(
            array(
                "required"            => "<b>{field}</b> alanı doldurulmalıdır",
                "is_unique"           => "<b>{field}</b> numaralı barkod başka ilaca aittir.",
                "min_length"          =>"Barkod numarası mutlaka 8 karakter olmalıdır.",
                "max_length"          =>"Barkod numarası mutlaka 8 karakter olmalıdır.",
                "numeric"  	          =>"<b>{field}</b> alanı sayısal değer içermelidir.",
                "greater_than"        =>"<b>{field}</b>, \"0\" değerine eşit veya büyük olmalıdır.",
                "less_than"           =>"<b>{field}</b>, \"100\" değerinden büyük olmamalıdır."
            )
        );

		$validate = $this->form_validation->run();

		if($validate){
			
			if($_FILES["img_url"]["name"] !== "") {
				
				$file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);
                $image_900x600 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/images/$this->viewFolder",900,600, $file_name);
				
				if($image_900x600){
					
					unlink("uploads/images/{$this->viewFolder}/900x600/$oldFileName->img_url");
					
					$update = $this->ilaclar_model->update(
						array("id" => $id),
						array(
							"barkod"           => $this->input->post("barkod"),
							"ilac_adi"         => $this->input->post("ilac_adi"),
							"stok"             => $this->input->post("stok"),
							"sgk_indirim"      => $this->input->post("sgk_indirim"),
							"expired_date"     => $this->input->post("expired_date"),
							"ilac_fiyati"      => $this->input->post("ilac_fiyati"),
							"indirimli_fiyat"  => $this->input->post("indirimli_fiyat"),
							"raf_numarasi"     => $this->input->post("raf_numarasi"),
							"img_url"          => $file_name
							)
					);

					if($update){

						$alert = array(
							"title" => "İşlem Başarılı",
							"text"  => "Kayıt başarılı bir şekilde güncellendi",
							"type"  => "success"
						);

					} else {

						$alert = array(
							"title" => "İşlem Başarısız",
							"text"  => "Kayıt Güncelleme sırasında bir problem oluştu",
							"type"  => "error"
						);
					}
					
				}else{
					$alert = array(
                        "title" => "İşlem Başarısız",
                        "text" => "Görsel yüklenirken bir problem oluştu",
                        "type" => "error"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("ilaclar/update_form/$id"));

                    die();
				}
				
			}else{
				
				$update = $this->ilaclar_model->update(
					array("id" => $id),
					array(
						"barkod"           => $this->input->post("barkod"),
						"ilac_adi"         => $this->input->post("ilac_adi"),
						"stok"             => $this->input->post("stok"),
						"sgk_indirim"      => $this->input->post("sgk_indirim"),
						"expired_date"     => $this->input->post("expired_date"),
						"ilac_fiyati"      => $this->input->post("ilac_fiyati"),
						"indirimli_fiyat"  => $this->input->post("indirimli_fiyat"),
						"raf_numarasi"     => $this->input->post("raf_numarasi"),
						)
				);
				
				if($update){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text"  => "Kayıt başarılı bir şekilde güncellendi",
                    "type"  => "success"
                );

				} else {

					$alert = array(
						"title" => "İşlem Başarısız",
						"text"  => "Kayıt Güncelleme sırasında bir problem oluştu",
						"type"  => "error"
					);
				}
			
			}
			
			$this->session->set_flashdata("alert", $alert);

			redirect(base_url("ilaclar"));

		} else {
			$viewData = new stdClass();

			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update";
			$viewData->form_error = true;
			$viewData->frontViewFolder = "admin";

			$viewData->ilac = $this->ilaclar_model->get(
				array(
					"id"    => $id,
				)
			);

			$this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
		}

	}


	public function delete($id){

		$fileName = $this->ilaclar_model->get(
			array(
				"id"    => $id
			)
		);

		$delete = $this->ilaclar_model->delete(
			array(
				"id"    => $id
			)
		);

		if($delete){
			
			unlink("uploads/images/{$this->viewFolder}/900x600/$fileName->img_url");
			
			$alert = array(
				"title" => "İşlem Başarılı",
				"text"  => "Kayıt başarılı bir şekilde silindi",
				"type"  => "success"
			);

		} else {

			$alert = array(
				"title" => "İşlem Başarısız",
				"text"  => "Kayıt silme sırasında bir problem oluştu",
				"type"  => "error"
			);
		}
		
		$this->session->set_flashdata("alert", $alert);
		redirect(base_url("ilaclar"));

	}

	public function expired(){

        $viewData = new stdClass();

        $expired_ilaclar = $this->ilaclar_model->get_expired();
		
		

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "expired";
        $viewData->frontViewFolder = "admin";
        $viewData->expired_ilaclar = $expired_ilaclar;

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

	
	public function delete_stock($id){
		
		$ilac = $this->ilaclar_model->get(
			array(
				"id"    => $id
			)
		);
		
		$update = $this->ilaclar_model->update(
				array("id" => $id),
				array(
                    "stok"          => 0
				)
			);
		
		redirect(base_url("expired"));
	}

	
	public function stockout(){

        $viewData = new stdClass();

        $stockout_ilaclar = $this->ilaclar_model->get_stockout();
		
		

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "stockout";
        $viewData->frontViewFolder = "admin";
        $viewData->stockout_ilaclar = $stockout_ilaclar;

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

	public function update_stock_form($id){

        $viewData = new stdClass();

        $ilac = $this->ilaclar_model->get(
            array(
                "id"    => $id,
            )
        );

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update_stock";
        $viewData->frontViewFolder = "admin";

        $viewData->ilac = $ilac;
        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }
	
	public function update_stock($id){

		$this->load->library("form_validation");

		$oldIlac = $this->ilaclar_model->get(
			array(
				"id"    => $id
			)
		);

        $this->form_validation->set_rules("stok", "Stok Durumu", "required|trim|numeric|greater_than[-1]");

        $this->form_validation->set_message(
            array(   
                "numeric"        =>"<b>{field}</b> alanı sayısal değer içermelidir.",
                "greater_than"   =>"<b>{field}</b>, \"0\" değerine eşit veya büyük olmalıdır."
            )
        );

		$validate = $this->form_validation->run();

		if($validate){

			$update = $this->ilaclar_model->update(
				array("id" => $id),
				array(
                    "stok"          => $this->input->post("stok")
				)
			);

			if($update){

				$alert = array(
					"title" => "İşlem Başarılı",
					"text"  => "Stok başarılı bir şekilde güncellendi",
					"type"  => "success"
				);

			} else {

				$alert = array(
					"title" => "İşlem Başarısız",
					"text"  => "Stok güncelleme sırasında bir problem oluştu",
					"type"  => "error"
				);
			}

			$this->session->set_flashdata("alert", $alert);

			redirect(base_url("ilaclar"));

		} else {
			
			$viewData = new stdClass();
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_stock";
			$viewData->form_error = true;
			$viewData->frontViewFolder = "admin";

			$viewData->ilac = $this->ilaclar_model->get(
				array(
					"id"    => $id,
				)
			);

			$this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
		}

	}




}
