<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index(){

		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		$role = $this->session->userdata("role");
		if($role== 99){
			redirect( site_url("main/admin"));
		}
		else{
			redirect( site_url("main/dashboard"));
		}

	}


	public function fac_req(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		   $data["class"] = $this->router->fetch_class();
		   $data["method"] = $this->router->fetch_method();

			$this->load->view("header",$data);
			$this->load->view("fac_req",$data);
			$this->load->view("footer",$data);
	}

	public function fac_exp(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		   $data["class"] = $this->router->fetch_class();
		   $data["method"] = $this->router->fetch_method();

			$this->load->view("header",$data);
			$this->load->view("fac_exp",$data);
			$this->load->view("footer",$data);
	}

   public function complaint(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		   $data["class"] = $this->router->fetch_class();
		   $data["method"] = $this->router->fetch_method();

			$this->load->model("DocumentModel");
			$data["factories"] = $this->DocumentModel->getComplaints();

			$this->load->view("header",$data);
			$this->load->view("complaint",$data);
			$this->load->view("footer",$data);
	}



}
