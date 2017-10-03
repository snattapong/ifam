<?php
/**
 * SpeedModel  Model
 *
 */
class SpeedModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getSpeeds(){
		 $this->db->order_by('speedID','asc');
		 return $this->db->get('speed');
	}

	public function get_speed(){
		 $speedID = $this->input->get("speedID");
		 $this->db->where('speedID',$speedID);
		 $result= $this->db->get('speed');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_speed(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('speed',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_speed(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("speedID",$data["speedID"] );
		 unset($data["speedID"]);
		 if( $this->db->update('speed',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_speed(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('speed')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
