<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		if($this->session->userdata("vloga") == "profesor"){
			$this->session->unset_userdata('spreminjanje');
			$this->load->view("vpis/profesor/prijavljen");
		}
		else if($this->session->userdata("vloga") == "dijak"){
			$this->load->view("vpis/dijak/prijavljen");
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
