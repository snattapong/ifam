<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

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

	public function work(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->model("WorkModel");
		$data["works"] = $this->WorkModel->getWorks();
		$data["class"] = $this->router->fetch_class();
		$data["method"] = $this->router->fetch_method();

		$this->load->view("header",$data);
		$this->load->view("work",$data);
		$this->load->view("footer",$data);
	}

	public function speed(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->model("SpeedModel");
		$data["speeds"] = $this->SpeedModel->getSpeeds();
		$data["class"] = $this->router->fetch_class();
		$data["method"] = $this->router->fetch_method();

		$this->load->view("header",$data);
		$this->load->view("speed",$data);
		$this->load->view("footer",$data);
	}

	public function doctype(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->model("DoctypeModel");
		$this->load->model("WorkModel");
		$data["doctypes"] = $this->DoctypeModel->getDoctypes();
		$data["works"] = $this->WorkModel->getWorks();
		$data["class"] = $this->router->fetch_class();
		$data["method"] = $this->router->fetch_method();

		$this->load->view("header",$data);
		$this->load->view("doctype",$data);
		$this->load->view("footer",$data);
	}


	public function action(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->model("ActionModel");
		$data["actions"] = $this->ActionModel->getActions();
		$data["class"] = $this->router->fetch_class();
		$data["method"] = $this->router->fetch_method();
		$this->load->view("header",$data);
		$this->load->view("action",$data);
		$this->load->view("footer",$data);
	}

	public function person(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->model("PersonModel");
		$data["persons"] = $this->PersonModel->getPersons();
		$data["class"] = $this->router->fetch_class();
		$data["method"] = $this->router->fetch_method();
		$this->load->view("header",$data);
		$this->load->view("person",$data);
		$this->load->view("footer",$data);
	}

	public function admin(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}
		$this->load->view("header");
			//$this->load->view("admin");
		$this->load->view("footer");

	}

	public function document(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		   $data["class"] = $this->router->fetch_class();
		   $data["method"] = $this->router->fetch_method();
			if($this->input->get('q')){
				$data["searchText"] = $this->input->get('q',true);
			}else{
				$data["searchText"] = null;
			}
			$this->load->model("PersonModel");
			$this->load->model("ActionModel");
			$this->load->model("DocumentModel");
			$this->load->model("AlarmModel");
			$this->load->model("DoctypeModel");
			$this->load->model("WorkModel");
			$this->load->model("AmphurModel");
			$this->load->model("ComptypeModel");
			$data["persons"] = $this->PersonModel->getPersons();
			$data["actions"] = $this->ActionModel->getActions();
			$data["documents"] = $this->DocumentModel->getDocuments();
			$data["works"] = $this->WorkModel->getWorks();
			$data["amphurs"] = $this->AmphurModel->getAmphurs();
			$data["doctypes"] = $this->DoctypeModel->getDoctypes();
			$data["comptypes"] = $this->ComptypeModel->getComptypes();

			$data["hasAlarm"] = $this->AlarmModel->hasAlarm();
			//$data["nearWorks"] = $this->DocumentModel->getDocumentDiff(0,15);
			//$data["overWorks"] = $this->DocumentModel->getDocumentDiff(-99999,-1);
			$data["workloads"] = $this->DocumentModel->getWorkload();

			$this->load->view("header",$data);
			$this->load->view("document",$data);
			$this->load->view("alarm",$data);
			$this->load->view("footer",$data);
	}

	public function dashboard(){
		if( !isset( $_SESSION["userid"]) ){
			redirect( site_url("main/login")); 
		}

		   $data["class"] = $this->router->fetch_class();
		   $data["method"] = $this->router->fetch_method();

			$this->load->model("PersonModel");
			$this->load->model("ActionModel");
			$this->load->model("DocumentModel");
			$this->load->model("AlarmModel");
			$data["persons"] = $this->PersonModel->getPersons();
			$data["actions"] = $this->ActionModel->getActions();
			$data["documents"] = $this->DocumentModel->getDocuments();

			$data["hasAlarm"] = $this->AlarmModel->hasAlarm();
			$data["nearWorks"] = $this->DocumentModel->getDocumentDiff(0,15);
			$data["overWorks"] = $this->DocumentModel->getDocumentDiff(-99999,-1);
			$data["workloads"] = $this->DocumentModel->getWorkload();

			$data["all_workloads"] = $this->DocumentModel->getAllWorkload();

			$this->load->view("header",$data);
			$this->load->view("dashboard",$data);
			$this->load->view("alarm",$data);
			$this->load->view("footer",$data);
	}

	public function login()
	{
		$this->load->model("UserModel");
		if($this->UserModel->authen()){
			redirect( site_url("main") );
		}
		else{

			$data["class"] = $this->router->fetch_class();
			$data["method"] = $this->router->fetch_method();
			$this->load->view("header",$data);
			$this->load->view("login",$data);
			$this->load->view("footer",$data);
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect( site_url());
	}
}
