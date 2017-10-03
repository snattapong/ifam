<?php
/**
 * ActionModel  Model
 *
 */
class ActionModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	function getActions(){
		 $this->db->order_by('actionID','asc');
		 return $this->db->get('action_command');
	}

	public function get_action(){
		 $actionID = $this->input->get("actionID");
		 $this->db->where('actionID',$actionID);
		 $result= $this->db->get('action_command');
		 if( $result->num_rows() > 0){
		 	$data = $result->row();
		 	$data->success = true;
		 }else{
		 	$data = array( "success" => false );
		 }
		 return $data;
	}
	public function add_action(){
		$data = $this->input->post(NULL, TRUE);
		if( $this->db->insert('action_command',$data) ){
			$data = array( "success" => true ) ;
		} else{
			$data = array( "success" => false ) ;
		}
		return $data;
	}
	public function update_action(){
	    $data = $this->input->post(NULL, TRUE);
		 $this->db->where("actionID",$data["actionID"] );
		 unset($data["actionID"]);
		 if( $this->db->update('action_command',$data)){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;

	}
	public function delete_action(){
		 $condition = $this->input->post(NULL, TRUE);
		 $this->db->where($condition);
		 if( $this->db->delete('action_command')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}
	 
}
