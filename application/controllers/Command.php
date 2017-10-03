<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Command extends CI_Controller {

	public function index() { } 

	public function getComplaints(){
		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getComplaints();
 		
		$complaints = array();  
		foreach($query->result() as $co){
		 	 $complaint = array( 
			 	'id'=> $co->id,
			 	'owner' => $co->forName.$co->firstName,
			 	'title' => $co->title,
				'location' => $co->location.($co->amphurID > 0 ? " อ.".$co->amphurName : "" ),
				'recieveDate' => $co->recieveDate,
				'documentNum' => $co->year."/".$co->recieveNum,
				'comptypeName' => $co->comptypeName
			  );
			 array_push($complaints,$complaint);
		 }
		 echo json_encode( array("data"=>$complaints));
	}

	public function getComplaintsBetween($fromDate,$toDate){

		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getComplaintsBetween($fromDate,$toDate);

		$complaints = array();  
		foreach($query->result() as $co){
		 	 $complaint = array( 
			 	'id'=> $co->id,
			 	'owner' => $co->forName.$co->firstName,
			 	'title' => $co->title,
				'location' => $co->location.($co->amphurID > 0 ? " อ.".$co->amphurName : "" ),
				'recieveDate' => $co->recieveDate,
				'documentNum' => $co->year."/".$co->recieveNum,
				'comptypeName' => $co->comptypeName
			  );
			 array_push($complaints,$complaint);
		 }
		 echo json_encode( array("data"=>$complaints));

	}





	public function getExpFacBetween($fromDate,$toDate){

		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getExpFacBetween($fromDate,$toDate);
		//$query = $this->DocumentModel->getRequestExpFactories();

 		$factories = array();  
		foreach($query->result() as $fa){
		 	 $factory = array( 
			 	'id'=> $fa->id,
			 	'contactName' => $fa->contactName,
			 	'certificateID' => $fa->certificateID,
				'location' => $fa->location.($fa->amphurID > 0 ? " อ.".$fa->amphurName : "" ),
				'contactDo' => $fa->contactDo,
				'certDate' => $fa->certDate,
				'documentNum' => $fa->year."/".$fa->recieveNum
			  );
			 array_push($factories,$factory);
		 }
		 echo json_encode( array("data"=>$factories));
	}


	public function getRequestExpFactories(){
		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getRequestExpFactories();
 		$factories = array();  
		foreach($query->result() as $fa){
		 	 $factory = array( 
			 	'id'=> $fa->id,
			 	'contactName' => $fa->contactName,
			 	'certificateID' => $fa->certificateID,
				'location' => $fa->location.($fa->amphurID > 0 ? " อ.".$fa->amphurName : "" ),
				'contactDo' => $fa->contactDo,
				'certDate' => $fa->certDate,
				'documentNum' => $fa->year."/".$fa->recieveNum
			  );
			 array_push($factories,$factory);
		 }
		 echo json_encode( array("data"=>$factories));
	}





	public function getRequestFactories(){
		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getRequestFactories();
 		$factories = array();  
		foreach($query->result() as $fa){
		 	 $factory = array( 
			 	'id'=> $fa->id,
			 	'contactName' => $fa->contactName,
			 	'certificateID' => $fa->certificateID,
				'location' => $fa->location.($fa->amphurID > 0 ? " อ.".$fa->amphurName : "" ),
				'contactDo' => $fa->contactDo,
				'certDate' => $fa->certDate,
				'documentNum' => $fa->year."/".$fa->recieveNum
			  );
			 array_push($factories,$factory);
		 }
		 echo json_encode( array("data"=>$factories));
	}
	
	public function getCertFacBetween($fromDate,$toDate){

		$this->load->model("DocumentModel");	
		$query = $this->DocumentModel->getCertFacBetween($fromDate,$toDate);

 		$factories = array();  
		foreach($query->result() as $fa){
		 	 $factory = array( 
			 	'id'=> $fa->id,
			 	'contactName' => $fa->contactName,
			 	'certificateID' => $fa->certificateID,
				'location' => $fa->location.($fa->amphurID > 0 ? " อ.".$fa->amphurName : "" ),
				'contactDo' => $fa->contactDo,
				'certDate' => $fa->certDate,
				'documentNum' => $fa->year."/".$fa->recieveNum
			  );
			 array_push($factories,$factory);
		 }
		 echo json_encode( array("data"=>$factories));
	}

	public function deleteFile(){
		$this->load->model("DocumentModel");	
		$result = $this->DocumentModel->deleteFile();
		echo json_encode($result);
	}

	public function upload(){
		 //upload file
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '1024'; //1 MB

		  $data = array();
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                 $data["message"] = 'Error during file upload' . $_FILES['file']['error'];
					  $data["success"] = false;
            } else {
                if (file_exists('uploads/' . $_FILES['file']['name'])) {
                    $data["message"] = 'File already exists : uploads/' . $_FILES['file']['name'];
					  	  $data["success"] = false;
                } else {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('file')) {
                        $data["message"] = $this->upload->display_errors();
					  	  		$data["success"] = false;
                    } else {
                        $data["message"] =  'File successfully uploaded : uploads/' . $_FILES['file']['name'];
								$data["upload_data"] = $this->upload->data();
								$data["files"] = $_FILES;
								$data["posts"] = $_POST;
					  	  		$data["success"] = true;

								$this->load->model("DocumentModel");
								$data["fileID"] = $this->DocumentModel->saveFile($this->upload->data());
                    }
                }
            }
        } else {
            $data["message"] = 'Please choose a file';
				$data["success"] = false;
       }
		echo json_encode( $data );
	}

	public function getDocumentFiles(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getDocumentFiles();
		echo json_encode($result);
	}

	public function closeJob(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->closeJob();
		echo json_encode($result);
	}

	public function revokeJob(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->revokeJob();
		echo json_encode($result);
	}

	public function closeMultipleJob(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->closeMultipleJob();
		echo json_encode($result);
	}

	public function getWorkloadInfo(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getWorkloadInfo();
		echo json_encode($result);
	}

	public function getPersonWorkload(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getPersonWorkload();
		echo json_encode($result);

	}

	public function getPersonWorkloadFull(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getPersonWorkloadFull();
		echo json_encode($result);

	}

	//for google chart
	//department
	public function getDAW($YEAR){ //department anually workload
		header("Content-type:application/json");
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getDAW($YEAR);
		echo json_encode($result);
	}

	public function getPAW($YEAR){ //permission anually workload
		header("Content-type:application/json");
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getPAW($YEAR);
		echo json_encode($result);
	}
	//staff
	public function getSAW($userID,$YEAR){ //staff anually workload
		header("Content-type:application/json");
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getSAW($userID,$YEAR);
		echo json_encode($result);
	}

	public function getSPAW($userID,$YEAR){ //staff permission anually workload
		header("Content-type:application/json");
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getSPAW($userID,$YEAR);
		echo json_encode($result);
	}


	public function getRDW(){
		header("Content-type:application/json");
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getRDW();
		echo json_encode($result);
	}

	public function getAllPersonWorkload(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getAllPersonWorkload();
		echo json_encode($result);
	}

	public function getWorkloadAll(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getWorkloadAll();
		echo json_encode($result);
	}

	public function setAlarmRemember(){
		$this->load->model("AlarmModel");
		$result = $this->AlarmModel->set_remember();
		echo json_encode($result);
	}

	public function newDocumentInfo(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->newDocumentInfo();
		echo json_encode($result);
	}

	public function getAlarmDate(){
		$this->load->model("AlarmModel");
		$result = $this->AlarmModel->getAlarmDate();
		echo json_encode($result);
	}

	public function newDocument(){

		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->newDocument();
		echo json_encode($result);
	}

	//ajax GET
	// params : documentID
	public function getDocument(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->getDocument();
		echo json_encode($result);
	}

	//ajax POST
	// params : documentID
	public function deleteDocument(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->deleteDocument();
		echo json_encode($result);
	}

	//ajax POST
	// params : documentID
	public function updateDocument(){
		$this->load->model("DocumentModel");
		$result = $this->DocumentModel->updateDocument();
		echo json_encode($result);
	}

	/*formatted template CRUD function
		public function add_method { }
		public function update_method {}
		public function get_method{ }
		public function delete_method{ }
	*/

		//Action class
		public function get_action(){ 
			$this->load->model("ActionModel");
			$result = $this->ActionModel->get_action();
			echo json_encode($result);
		}

		public function add_action() { 
			$this->load->model("ActionModel");
			$result = $this->ActionModel->add_action();
			echo json_encode($result);
		}

		public function update_action(){
			$this->load->model("ActionModel");
			$result = $this->ActionModel->update_action();
			echo json_encode($result);
		}

		
		public function delete_action(){ 
			$this->load->model("ActionModel");
			$result = $this->ActionModel->delete_action();
			echo json_encode($result);
		}

		//Person class

		public function get_person(){ 
			$this->load->model("PersonModel");
			$result = $this->PersonModel->get_person();
			echo json_encode($result);
		}

		public function add_person() { 
			$this->load->model("PersonModel");
			$result = $this->PersonModel->add_person();
			echo json_encode($result);
		}

		public function update_person(){
			$this->load->model("PersonModel");
			$result = $this->PersonModel->update_person();
			echo json_encode($result);
		}

		public function delete_person(){ 
			$this->load->model("PersonModel");
			$result = $this->PersonModel->delete_person();
			echo json_encode($result);
		}


		//Speed class
		public function get_speed(){ 
			$this->load->model("SpeedModel");
			$result = $this->SpeedModel->get_speed();
			echo json_encode($result);
		}

		public function add_speed() { 
			$this->load->model("SpeedModel");
			$result = $this->SpeedModel->add_speed();
			echo json_encode($result);
		}

		public function update_speed(){
			$this->load->model("SpeedModel");
			$result = $this->SpeedModel->update_speed();
			echo json_encode($result);
		}

		
		public function delete_speed(){ 
			$this->load->model("SpeedModel");
			$result = $this->SpeedModel->delete_speed();
			echo json_encode($result);
		}

		//Doctype class
		public function get_doctype(){ 
			$this->load->model("DoctypeModel");
			$result = $this->DoctypeModel->get_doctype();
			echo json_encode($result);
		}

		public function add_doctype() { 
			$this->load->model("DoctypeModel");
			$result = $this->DoctypeModel->add_doctype();
			echo json_encode($result);
		}

		public function update_doctype(){
			$this->load->model("DoctypeModel");
			$result = $this->DoctypeModel->update_doctype();
			echo json_encode($result);
		}

		
		public function delete_doctype(){ 
			$this->load->model("DoctypeModel");
			$result = $this->DoctypeModel->delete_doctype();
			echo json_encode($result);
		}

		//Work class
		public function get_work(){ 
			$this->load->model("WorkModel");
			$result = $this->WorkModel->get_work();
			echo json_encode($result);
		}

		public function add_work() { 
			$this->load->model("WorkModel");
			$result = $this->WorkModel->add_work();
			echo json_encode($result);
		}

		public function update_work(){
			$this->load->model("WorkModel");
			$result = $this->WorkModel->update_work();
			echo json_encode($result);
		}

		
		public function delete_work(){ 
			$this->load->model("WorkModel");
			$result = $this->WorkModel->delete_work();
			echo json_encode($result);
		}
}
