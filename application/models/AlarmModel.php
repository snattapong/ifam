<?php
/**
 * ActionModel  Model
 *
 */
class AlarmModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	public function hasAlarm(){

		 $this->db->where('alarmUser',$this->session->userdata('userid'));
		 $this->db->where('todayAlarm',1);
		 $result = $this->db->get('v_alarm');
		 if($result->num_rows() == 0){ //create new
			$this->db->set("alarmUser",$this->session->userdata('userid'));
		 	$this->db->insert("alarm");
			return TRUE;
		 }else{
		 	//check if remember's flag is not set	
			$alarm = $result->row();
			$remember  = $alarm->remember == 0 ;
			$alarmID = $alarm->alarmID ;

			//increment count value
			if( $remember == 1){
					$this->db->set("count","count+1",FALSE);
					$this->db->where("alarmID",$alarmID);
					$this->db->update("alarm");
			}

			return $remember;
		 }
	}

	public function getAlarmDate(){
		$workID = $this->input->get("workID");
		$doctypeID = $this->input->get("doctypeID");
		$speed = 0 ;
		if($workID == null || $workID < 1){
			$speed = 0;
			 //echo "SPEED0 = $speed";
		}
		else{

				  if( $doctypeID == 0){
					  $this->db->where("workID",$workID);
					  $result= $this->db->get("work")->row();
					  $speed = $result->speedValue;
					  //echo "SPEED1 = $speed";
				  }else{
					  $this->db->where("doctypeID",$doctypeID);
					  $result= $this->db->get("doctype")->row();
					  $speed = $result->speedValue;
					  //echo "doctype= $doctypeID SPEED2 = $speed";
				  }
		}

		$sql = " SELECT 
					date_format(  
						( NOW() +  INTERVAL ". $speed ." DAY  )  + INTERVAL 543 YEAR 
						,'%d/%m/%Y' ) 
					 AS `alarmDate` " ;
		$alarm = $this->db->query($sql)->row();	
		return array( 
				"success" => true,
				"alarmDate" => $alarm->alarmDate
		);
	}

	public function set_remember(){
		 $this->db->where('alarmUser',$this->session->userdata('userid'));
		 $this->db->where('DATE(NOW())=DATE(createDate)',NULL,FALSE);
		 $this->db->set('remember', intval($this->input->post("remember")) );
		 if( $this->db->update('alarm')){
			$data = array( "success" => true ) ;
		 }else{
			$data = array( "success" => false ) ;
		 }
		return $data;
	}

}
