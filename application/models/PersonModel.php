<?php
/**
 * PersonModel  Model
 *
 */
class PersonModel  extends CI_Model  {
	function __construct()
    {
        parent::__construct();
    }

	function getPersons(){
		 $this->db->order_by('order','desc');
		 return $this->db->get('person');
	}

	public function get_person(){
		 $personID = $this->input->get("personID");
		 $this->db->where('personID',$personID);
		 $result= $this->db->get('person');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}

	public function add_person(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('person',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_person(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("personID",$data["personID"] );
		 unset($data["personID"]);
		 if( $this->db->update('person',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_person(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('person')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}

	 
}
