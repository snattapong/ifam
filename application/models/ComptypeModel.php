<?php
/**
 * Comptype  Model
 *
 */
class ComptypeModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getComptypes(){
		 $this->db->order_by('comptypeID','asc');
		 return $this->db->get('comptype');
	}

	public function get_comptype(){
		 $comptypeID = $this->input->get("comptypeID");
		 $this->db->where('comptypeID',$comptypeID);
		 $result= $this->db->get('comptype');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_comptype(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('comptype',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_comptype(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("comptypeID",$data["comptypeID"] );
		 unset($data["comptypeID"]);
		 if( $this->db->update('comptype',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_comptype(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('comptype')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
