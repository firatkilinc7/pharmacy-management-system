<?php

class Userop extends CI_Controller {

    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->viewFolder = "users_v";

        $this->load->model("user_model");

    }


    public function login(){

        if(get_active_user()){
            redirect('Dashboard');
        }

        $viewData = new stdClass();

        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "login";
        $viewData->frontViewFolder = "admin";

        $this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }
	
	public function logout(){

		$this->load->library('session');
		$this->session->unset_userdata("user");
		redirect(base_url("login"));

	}


    public function do_login(){

       if(get_active_user()){
			redirect('Dashboard');
		}

		$this->load->library("form_validation");

		$this->form_validation->set_rules("user_email", "E-posta", "required|trim|valid_email");
		$this->form_validation->set_rules("user_password", "Şifre", "required|trim|min_length[6]|max_length[8]");

		$this->form_validation->set_message(
			array(
				"required"    => "<b>{field}</b> alanı doldurulmalıdır",
				"valid_email" => "Lütfen geçerli bir e-posta adresi giriniz",
				"min_length"  => "<b>{field}</b> en az 6 karakterden oluşmalıdır",
				"max_length"  => "<b>{field}</b> en fazla 8 karakterden oluşmalıdır",
			)
		);

		if($this->form_validation->run() == FALSE){

			$viewData = new stdClass();


			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "login";
			$viewData->form_error = true;
			$viewData->frontViewFolder = "admin";

			$this->load->view("{$viewData->frontViewFolder}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

		} else {


			$user = $this->user_model->get(
				array(
					"email"     => $this->input->post("user_email"),
					"password"  => md5($this->input->post("user_password")),
					"isActive"  => 1
				)
			);

			if($user){

				$alert = array(
					"title" => "İşlem Başarılı",
					"text" => "$user->full_name hoşgeldiniz",
					"type"  => "success"
				);

				$this->session->set_userdata("user", $user);
				$this->session->set_flashdata("alert", $alert);

				redirect('Dashboard');

			} else {


				$alert = array(
					"title" => "İşlem Başarısız",
					"text" => "Lütfen giriş bilgilerinizi kontrol ediniz",
					"type"  => "error"
				);

				$this->session->set_flashdata("alert", $alert);

				redirect(base_url("login"));

			}

		}
	}
}
