<?php
/**
 * WorkModel  Model
 *
 */
class WorkModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getWorks(){
		 $this->db->order_by('workID','asc');
		 return $this->db->get('work');
	}

	public function get_work(){
		 $workID = $this->input->get("workID");
		 $this->db->where('workID',$workID);
		 $result= $this->db->get('work');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_work(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('work',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_work(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("workID",$data["workID"] );
		 unset($data["workID"]);
		 if( $this->db->update('work',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_work(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('work')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
