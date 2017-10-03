<?php
/**
 * DoctypeModel  Model
 *
 */
class DoctypeModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getDoctypes(){
		 $this->db->order_by('doctypeID','asc');
		 return $this->db->get('v_doctype');
	}

	public function get_doctype(){
		 $doctypeID = $this->input->get("doctypeID");
		 $this->db->where('doctypeID',$doctypeID);
		 $result= $this->db->get('doctype');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_doctype(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('doctype',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_doctype(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("doctypeID",$data["doctypeID"] );
		 unset($data["doctypeID"]);
		 if( $this->db->update('doctype',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_doctype(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('doctype')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
