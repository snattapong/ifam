<?php
/**
 * AmphurModel  Model
 *
 */
class AmphurModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getAmphurs(){
		 $this->db->order_by('amphurID','asc');
		 return $this->db->get('amphur');
	}

	public function get_amphur(){
		 $amphurID = $this->input->get("amphurID");
		 $this->db->where('amphurID',$amphurID);
		 $result= $this->db->get('amphur');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_amphur(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('amphur',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_amphur(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("amphurID",$data["amphurID"] );
		 unset($data["amphurID"]);
		 if( $this->db->update('amphur',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_amphur(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('amphur')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
