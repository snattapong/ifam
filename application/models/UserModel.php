<?php
/**
 * UserModel  Model
 *
 */
class UserModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	 function authen(){
			$username = $this->input->post("username");
			$password = $this->input->post("userpass");

			if($username == null || $password == null ){ return false; }


	 	   $this->db->where("username", $username);
	 	   $this->db->where("userpass", $password);
	 	   $query = $this->db->get("users");

		  if($query->num_rows() < 1 ){
		  		return false;
		  }else{
		  		//create session
				$info = $query->row();

				$this->session->set_userdata("userid",$info->userID);
				$this->session->set_userdata("forName",$info->forName);
				$this->session->set_userdata("firstName",$info->firstName);
				$this->session->set_userdata("lastName",$info->lastName);
				$this->session->set_userdata("role",$info->role);
				return true;
		  }
	 }

}
