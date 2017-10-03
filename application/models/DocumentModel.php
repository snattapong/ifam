<?php
/**
 * ActionModel  Model
 *
 */
class DocumentModel  extends CI_Model  {


	function __construct()
    {
        parent::__construct();
    }

	//$query = $this->DocumentModel->getExpFacBetween($fromDate,$toDate);
	//$query = $this->DocumentModel->getRequestExpFactories();

	function getRequestExpFactories(){
	 	$sql = "SELECT id,contactName,certificateID,location
					,document.amphurID amphurID,amphurName,contactDo,regisCer
					,date_format((certDate + interval 543 year),'%d/%m/%Y') AS certDate
					,recieveNum,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS year  
  				FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				WHERE doctypeID in (10,11) ";
		 $query = $this->db->query($sql);		
		 return  $query;
	}

	function getExpFacBetween($fromDate,$toDate){
		 $sql = "SELECT id,contactName,certificateID,location
					,document.amphurID amphurID,amphurName,contactDo,regisCer
					,date_format((certDate + interval 543 year),'%d/%m/%Y') AS certDate
					,recieveNum,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS year  
  				FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				WHERE doctypeID in (10,11) AND ( DATE(recieveDate) BETWEEN '$fromDate' AND '$toDate' ) ";
		 $query = $this->db->query($sql);		
		 return  $query;
	 }




	function getRequestFactories(){
	 	$sql = "SELECT id,contactName,certificateID,location
					,document.amphurID amphurID,amphurName,contactDo,regisCer
					,date_format((certDate + interval 543 year),'%d/%m/%Y') AS certDate
					,recieveNum,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS year  
  				FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				WHERE doctypeID = 4 ";
		 $query = $this->db->query($sql);		
		 return  $query;
	 }
	
	 function getCertFacBetween($fromDate,$toDate){
		 $sql = "SELECT id,contactName,certificateID,location
					,document.amphurID amphurID,amphurName,contactDo,regisCer
					,date_format((certDate + interval 543 year),'%d/%m/%Y') AS certDate
					,recieveNum,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS year  
  				FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				WHERE doctypeID = 4 AND regisCer=1  AND ( DATE(certDate) BETWEEN '$fromDate' AND '$toDate' ) ";
		 $query = $this->db->query($sql);		
		 return  $query;
	 }



	 function getRequestCloseFactories(){
	 	$this->db->select('*');
		$this->db->from('document');
		$this->db->join('amphur', 'document.amphurID = amphur.amphurID', 'left');
	 	$this->db->where('doctypeID',10);
	 	$this->db->or_where('doctypeID',11);
		$query = $this->db->get();
		return $query;
	 }

	 function getComplaints(){
		$sql = "SELECT id,title,owner,location,document.amphurID amphurID,amphurName,recieveNum,person.forName,person.firstName
			,date_format((`document`.`recieveDate` + interval 543 year),'%d/%m/%Y') AS `recieveDate`
			,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS `year`
			,comptype.comptypeName 
  				 FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				LEFT JOIN person on document.owner = person.personID 
				LEFT JOIN complaint on document.id =  complaint.documentID
 				LEFT JOIN comptype  on complaint.comptypeID = comptype.comptypeID  
 				
				WHERE workID=2 " ;

		$query = $this->db->query($sql);		
	 	return $query;
	 }


	 function getComplaintsBetween($fromDate,$toDate){
		$sql = "SELECT id,title,owner,location,document.amphurID amphurID,amphurName,recieveNum,person.forName,person.firstName
			,date_format((`document`.`recieveDate` + interval 543 year),'%d/%m/%Y') AS `recieveDate`
			,date_format((`document`.`recieveDate` + interval 543 year),'%Y') AS `year`
			,comptype.comptypeName 
  				 FROM document 
 				LEFT JOIN amphur on amphur.amphurID = document.amphurID 
 				LEFT JOIN person on document.owner = person.personID 
				LEFT JOIN complaint on document.id =  complaint.documentID
 				LEFT JOIN comptype  on complaint.comptypeID = comptype.comptypeID  
 				
				WHERE workID=2 AND ( DATE(document.recieveDate) BETWEEN '$fromDate' AND '$toDate') " ;
		$query = $this->db->query($sql);		
	 	return $query;
	 }

	 	function closeJob(){
		
		$this->db->where('id',$this->input->post('documentID') );
		$this->db->set('success',1,FALSE);
		$this->db->set('successDate',"NOW()",FALSE);
		return array( 'success' => $this->db->update('document')) ;
	}

	//revoke form closedJob
	function revokeJob(){
		$this->db->where('id',$this->input->post('documentID') );
		$this->db->set('success',0,FALSE);
		return array( 'success' => $this->db->update('document')) ;
	}

	function closeMultipleJob(){
		$ids = $this->input->post("ids");	
		$this->db->where_in('id',$ids);
		$this->db->set('success','1-success',FALSE);
		$this->db->set('successDate',"NOW()",FALSE);
		return array( 'success' => $this->db->update('document')) ;
	}



	function deleteFile(){
		$fileID = $this->input->post("fileID");
		$this->db->where("fileID", $fileID);
		$query=$this->db->get("upload_file");
		$file_name = $query->row()->file_name ;
		if(unlink("uploads/$file_name")){
			$this->db->where("fileID", $fileID);
			$this->db->delete("upload_file");
			return array( 'success' => true) ;
		}else{
			return array( 'success' => false, 'message' => 'Cannot remove file' ) ;
		}
	}
	
	function getDocumentFiles(){
		$this->db->where("documentID", $this->input->get("documentID"));
		$this->db->order_by("upload_time","desc");
		$query = $this->db->get("upload_file");
		$files = array();
		foreach($query->result() as $file){
			array_push($files, array( 
					'fileID' => $file->fileID,
					'file_name' => $file->file_name ,
					'orig_name' => $file->orig_name ,
					'file_type' => $file->file_type ,
					'is_image'  => $file->is_image,
					'ip_address' => $file->ip_address,
					'upload_time' => $file->upload_time,
					'image_width' => $file->image_width,
					'image_height' => $file->image_height
					));
		}
		return $files;
	}

	function saveFile($upload){
		$data = array(
			'file_name' => $upload["file_name"], 	
			'file_size' => $upload["file_size"],
			'documentID' => $this->input->post("documentID"),
			'ip_address' => $this->input->ip_address(),
			'orig_name' => $upload["orig_name"],
			'file_type' => $upload["file_type"],
			'is_image' => intVal( $upload['is_image']),
			'image_width' => intVal( $upload['image_width']),
			'image_height' => intVal( $upload['image_height']) 
		);
		$this->db->insert('upload_file',$data);
		return  $this->db->insert_id();
	}

	function getDocument(){
		$this->db->where('id',$this->input->get('documentID') );
		$result=$this->db->get('v_document');
		if($result->num_rows() > 0){
				  $doc= $result->row();
				  $data = array(
					  'success' => true,
					  'id' => $this->input->get('documentID'),
					  'recieveNum' => $doc->recieveNum,		
					  'recieveDate' => $doc->recieveDate,		
					  'factory_recieveNum' => $doc->factory_recieveNum,		
					  'factory_recieveDate' => $doc->factory_recieveDate,		
					  'owner' => $doc->owner,
					  'alarmDate' => $doc->alarmDate,
					  'title' => $doc->title,
					  'contactName' =>$doc->contactName,
					  'contactType' =>$doc->contactType,
					  'actionID' => $doc->actionID,
					  'commandText' => $doc->commandText,
					  'alarmStop' => $doc->alarmStop,
					  'sendDate' => $doc->sendDate,
					  'certificateID' => $doc->certificateID,
					  'location' => $doc->location,
					  'amphurID' => $doc->amphurID,
					  'workID' => $doc->workID,
					  'doctypeID' => $doc->doctypeID,
					  'command37' => $doc->command37,
					  'regisCer' => $doc->regisCer,
					  'contactDo' => $doc->contactDo,
					  'certDate' => $doc->certDate,
					  'isSuccess' => $doc->success,
					  'fact' => $doc->fact,
					  'comptypeID' => $doc->comptypeID,
					  'operation' => $doc->operation,
					  'summary' => $doc->summary,
					  'year' => $doc->year,
					  'files'=> $this->getDocumentFiles()
				  );
				  return $data;
		}
		else{
			return array( 'success' => false );
		}
	}

	function getDocuments(){
		$this->db->order_by('recieveNum','desc');
		$this->db->order_by('recieveDate','desc');
		return $this->db->get('v_document');
	}

	function deleteDocument(){
		$this->db->where('id', $this->input->post('documentID') );
		if( $this->db->delete('document')){
			return array( 'success' => true)  ;
		}else{
			return  array( 'success' => false ) ;
		}
	}

	function getDocumentDiff($fromDiff=0,$endDiff=0){
		$this->db->where('diff >=', $fromDiff );
		$this->db->where('diff <=', $endDiff ); //change here 
		return $this->db->get('v_document');
	}

	function getWorkLoad(){
		$sql = "
		  SELECT a.owner,a.name,a.workload,b.remain,c.over
		  FROM ( 
     			SELECT count(0) workload,owner,CONCAT(forName,'',firstName) name  
				FROM v_document  
				WHERE diff IS NOT NULL  
				AND success = 0 
				GROUP BY owner) a 
   	  LEFT JOIN (
	  			SELECT  count(0) remain,owner 
				FROM v_document  
				WHERE diff >= 0 
				AND success = 0 
				GROUP BY owner) b ON a.owner = b.owner 
		  LEFT JOIN ( 
				SELECT count(0) over, owner 
				FROM v_document 
				WHERE diff < 0 
				AND success = 0 
				GROUP BY owner ) c ON a.owner = c.owner
		";
		return $this->db->query($sql);
	}


	function getSPAW($userID,$YEAR){ // Staff Permission Anually Workload

		$sql = " SELECT  document.doctypeID,doctype.doctypeName,count(*) AS count 
				FROM document
				LEFT JOIN doctype ON document.doctypeID = doctype.doctypeID
				WHERE year=$YEAR AND owner=$userID AND document.workID = 1 
				GROUP BY doctypeID,owner";

		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->result() as $workLoad){
			//array_push($workID,$workLoad->workID);
			$row=array( $workLoad->doctypeName == NULL ? "ไม่ระบุ" : $workLoad->doctypeName , $workLoad->count, $workLoad->doctypeID ); 
			array_push($rows,$row);
		}
		return $rows ;
	}

	function getSAW($userID,$YEAR){ // Staff Anually Workload

		$sql = "
				SELECT  document.workID,work.workName,count(*) AS count 
				FROM document 
				JOIN work ON document.workID = work.workID
				WHERE year=$YEAR AND owner=$userID 
				GROUP BY workID,owner ;
		";

		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->result() as $workLoad){
			//array_push($workID,$workLoad->workID);
			$row=array( $workLoad->workName , $workLoad->count, $workLoad->workID ); 
			array_push($rows,$row);
		}

		return $rows ;
	}





	function getPAW($YEAR){ // Permission Anually Workload

		$sql = " SELECT  document.doctypeID,doctype.doctypeName,count(*) AS count 
				FROM document
				LEFT JOIN doctype ON document.doctypeID = doctype.doctypeID
				WHERE year=$YEAR AND document.workID = 1 
				GROUP BY doctypeID ";

		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->result() as $workLoad){
			//array_push($workID,$workLoad->workID);
			$row=array( $workLoad->doctypeName == null ? "ไม่ระบุ" : $workLoad->doctypeName , $workLoad->count, $workLoad->doctypeID ); 
			array_push($rows,$row);
		}

		return $rows ;
	}



	function getDAW($YEAR){ // Department Anually Workload

		$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				WHERE year=$YEAR
				GROUP BY workID ;
		";

		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->result() as $workLoad){
			//array_push($workID,$workLoad->workID);
			$row=array( $workLoad->workName , $workLoad->count, $workLoad->workID ); 
			array_push($rows,$row);
		}

		return $rows ;
	}



	function getRDW(){

		$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				WHERE success = 0  
				GROUP BY workID ;
		";

		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->result() as $workLoad){
			//array_push($workID,$workLoad->workID);
			$row=array( $workLoad->workName , $workLoad->count, $workLoad->workID ); 
			array_push($rows,$row);
		}

		return $rows ;
	}





	function getAllPersonWorkload(){

		$chartColor = array(
		  "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e",
        "#3498db",
        "#95a5a6"
		);

		$chartLabel = array();
		$chartData = array();
		$workID = array();

			$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				WHERE success = 0  
				GROUP BY workID ;
		";
		$query = $this->db->query($sql);
		foreach($query->result() as $workLoad){
			array_push($workID,$workLoad->workID);
			array_push($chartLabel,$workLoad->workName);
			array_push($chartData,$workLoad->count);
		}

		return array (
			"chartColor" => $chartColor,
			"chartLabel" => $chartLabel,
			"chartData" => $chartData,
			"workID" => $workID,
			"success"=> true
		);
	}

	function getWorkloadAll(){

		$chartColor = array(
		  "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e",
        "#3498db",
        "#95a5a6"
		);

		$chartLabel = array();
		$chartData = array();
		$workID = array();

			$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				GROUP BY workID ;
		";
		$query = $this->db->query($sql);
		foreach($query->result() as $workLoad){
			array_push($workID,$workLoad->workID);
			array_push($chartLabel,$workLoad->workName);
			array_push($chartData,$workLoad->count);
		}

		return array (
			"chartColor" => $chartColor,
			"chartLabel" => $chartLabel,
			"chartData" => $chartData,
			"workID" => $workID,
			"success"=> true
		);
	}

	function getPersonWorkloadFull(){

		$chartColor = array(
		  "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e",
        "#3498db",
        "#95a5a6"
		);

		$chartLabel = array();
		$chartData = array();
		$workID = array();

		$owner= $this->input->get("personID");
			$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				WHERE owner=$owner 
				GROUP BY workID ;
		";
		$query = $this->db->query($sql);
		foreach($query->result() as $workLoad){
			array_push($workID,$workLoad->workID);
			array_push($chartLabel,$workLoad->workName);
			array_push($chartData,$workLoad->count);
		}

		return array (
			"chartColor" => $chartColor,
			"chartLabel" => $chartLabel,
			"chartData" => $chartData,
			"workID" => $workID,
			"success"=> true
		);
	}



	function getPersonWorkload(){

		$chartColor = array(
		  "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e",
        "#3498db",
        "#95a5a6"
		);

		$chartLabel = array();
		$chartData = array();
		$workID = array();

		$owner= $this->input->get("personID");
			$sql = "
				SELECT  v_document.workID,work.workName,count(*) AS count 
				FROM v_document 
				JOIN work ON v_document.workID = work.workID
				WHERE owner=$owner and success = 0  
				GROUP BY workID ;
		";
		$query = $this->db->query($sql);
		foreach($query->result() as $workLoad){
			array_push($workID,$workLoad->workID);
			array_push($chartLabel,$workLoad->workName);
			array_push($chartData,$workLoad->count);
		}

		return array (
			"chartColor" => $chartColor,
			"chartLabel" => $chartLabel,
			"chartData" => $chartData,
			"workID" => $workID,
			"success"=> true
		);
	}


	function getAllWorkLoad(){
		$this->db->order_by('owner','asc');
		return $this->db->get('v_all_workload');
	}

	public function getWorkLoadInfo(){
		$owner = $this->input->get('owner');
		$this->db->where('owner' , $this->input->get('owner'));
		$this->db->where('diff is not null' ,"",false);
		$this->db->where('success' ,0);
		$this->db->order_by('diff','asc');
		$works = $this->db->get('v_document');
		$html = "<a id='alarm-back-btn' href='javascript:flip();' ><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> ย้อนกลับ </a>
					<table class='table table-bordered table-striped'>
					<tr><th style='width:80%' class='text-center'>เรื่อง</th><th class='text-center'>เหลือเวลา</th></tr>";

		foreach($works->result() as $work){
			$html.="<tr>";
			$html .= "<td><a href='javascript:showInfo(".$work->id.")' class='work-info' data-id='".$work->id."'>".$work->title."</td>";	
			$html .= "<td align='center'>".$work->diff. "  วัน</td>";	
			$html.="</tr>";
		}
		$html .= "</table>";

		return array( 
			"html" => $html,
			"success" => true
		) ;
	}



	function updateDocument(){
	  $this->db->where('id', $this->input->post('documentID'));
	  $data = array(
			'recieveNum' => $this->input->post('recieveNum'),		
			'recieveDate' => $this->input->post('recieveDate'),		
			'factory_recieveNum' => $this->input->post('factory_recieveNum'),		
			'factory_recieveDate' => $this->input->post('factory_recieveDate'),		
			'owner' => $this->input->post("owner"),
			'alarmDate' => $this->input->post('alarmDate'),
			'title' => $this->input->post('title'),
			'contactName' =>$this->input->post('contactName'),
			'contactType' =>$this->input->post('contactType'),
			'actionID' => $this->input->post('actionID') == null ? 0 : $this->input->post('actionID') ,
			'commandText' => $this->input->post('commandText'),
			'sendDate' => $this->input->post('sendDate'),
			'alarmStop' => intval($this->input->post('alarmStop')),
			'command37' => intval($this->input->post('command37')),
			'success' => intval($this->input->post('success')),
			'regisCer' => intval($this->input->post('regisCer')),
			'contactDo' => $this->input->post('contactDo'),
			'certDate' => $this->input->post('certDate'),
			'complaint' => $this->input->post('complaint'),
			'certificateID' => $this->input->post('certificateID'),
			'location' => $this->input->post('loc'),
			'amphurID' => $this->input->post('amphurID'),
			'workID' => $this->input->post('workID'),
			'doctypeID' => $this->input->post('doctypeID'),
			'year' => 2017
		);
		
		//print_r($data);
		if( $this->db->update('document',$data)){

			$workID = $this->input->post('workID');
			if($workID == 2){ //งานร้องเรียน
					  
					  $this->db->where('documentID', $this->input->post('documentID'));
					  $row= $this->db->get('complaint')->num_rows();
					  
					  //update complaint table record 
					  if($row > 0){
								 $data = array(
											'summary' => $this->input->post('summary'),		
											'operation' => $this->input->post('operation'),		
											'fact' => $this->input->post('fact'),		
											'comptypeID' => $this->input->post('comptypeID')		
								 );
								 $this->db->where('documentID', $this->input->post('documentID'));
					   		$this->db->update('complaint',$data); 
						}else{
								 //insert new complaint table record 
								 $data = array(
											'summary' => $this->input->post('summary'),		
											'operation' => $this->input->post('operation'),		
											'fact' => $this->input->post('fact'),		
											'comptypeID' => $this->input->post('comptypeID'),
											'documentID' =>$this->input->post('documentID')	
								 );
								 $this->db->insert('complaint',$data);
					  }
			}

			return array( 'success' => true)  ;
		}else{
			//echo "<h1>not success</h1>";	
			//die();
			return  array( 'success' => false ) ;
		}
	}

	function newDocumentInfo(){
		 /*
		 $this->db->where('speedID',1);
		 $result = $this->db->get('speed')->row();
		 $speed = $result->speedValue ;
		 $sql = " SELECT 
					date_format(  
						( NOW() +  INTERVAL ". $speed ." DAY  )  + INTERVAL 543 YEAR  
						,'%d/%m/%Y' ) 
					 AS `alarmDate` " ;
		 $alarm = $this->db->query($sql)->row();	
		 $alarmDate = $alarm->alarmDate ;
		 */
		
		 $result = $this->db->get('v_newdocumentinfo');
		 if( $result->num_rows() > 0){
					$result = $result->row();	
					$info= array( 
							  "success"=> true ,
							  "recieveDate" => $result->recieveDate,
							  "recieveNum" => $result->recieveNum
					);
		 }	 
		 else{
				$info= array( "success"=> false );
		}

		return $info;
	}

	function newDocument(){
		$data = array(
			'recieveNum' => $this->input->post('recieveNum'),		
			'recieveDate' => $this->input->post('recieveDate'),		
			'factory_recieveNum' => $this->input->post('factory_recieveNum'),		
			'factory_recieveDate' => $this->input->post('factory_recieveDate'),		
			'owner' => $this->input->post("owner"),
			'alarmDate' => $this->input->post('alarmDate'),
			'title' => $this->input->post('title'),
			'contactName' =>$this->input->post('contactName'),
			'contactType' =>$this->input->post('contactType'),
			'actionID' => $this->input->post('actionID'),
			'commandText' => $this->input->post('commandText'),
			'sendDate' => $this->input->post('sendDate'),
			'alarmStop' => intVal($this->input->post('alarmStop')),
			'command37' => intVal($this->input->post('command37')),
			'regisCer' => intVal($this->input->post('regisCer')),
			'success' => intVal($this->input->post('success')),
			'contactDo' => $this->input->post('contactDo'),
			'certDate' => $this->input->post('certDate'),
			'complaint' => $this->input->post('complaint'),
			'certificateID' => $this->input->post('certificateID'),
			'location' => $this->input->post('loc'),
			'amphurID' => $this->input->post('amphurID'),
			'workID' => $this->input->post('workID'),
			'doctypeID' => $this->input->post('doctypeID'),
			'year' => 2017
		);
		//print_r($data);

		if( $this->db->insert('document',$data)){
			$documentID =  $this->db->insert_id();
			$workID = $this->input->post('workID');
			if($workID == 2){ //งานร้องเรียน
					  //update complaint table record 
					  $data = array(
								 'summary' => $this->input->post('summary'),		
								 'operation' => $this->input->post('operation'),		
								 'fact' => $this->input->post('fact'),		
								 'comptypeID' => $this->input->post('comptypeID'),
								 'documentID' => $documentID
					  );
					  $this->db->insert('complaint',$data);
			}
			return array( 'success' => true, 'documentID' => $documentID ) ;
		}else{
			return  array( 'success' => false ) ;
		}
	}
	 
}
