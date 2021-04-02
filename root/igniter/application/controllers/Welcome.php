<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("dejavnost_model");
        $this->load->model("prijavni_model");
    }


	public function index()
	{
		if($this->session->userdata("vloga") == "profesor"){
			$this->session->unset_userdata('spreminjanje');
			$this->load->view("vpis/profesor/prijavljen");
		}
		else if($this->session->userdata("vloga") == "dijak"){
			$obvestila["obvestila"] = $this->dejavnost_model->domovDijak($this->session->userdata("idOseba"));
			$this->load->view("vpis/dijak/prijavljen", $obvestila);
		}
		else if($this->session->userdata("vloga") == "admin"){
			$this->session->unset_userdata('spreminjanje');
			$this->load->view("vpis/admin/prijavljen");
		}
		else{
			redirect("prijava/vpis");
		}
	}

}
