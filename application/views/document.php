<ol class="breadcrumb">
  <li><a href="<?=site_url()?>">Home</a></li>
  <li class="active">แฟ้มเอกสาร</li>
</ol>

<table id='document-table' class="table table-bordered responsive wrap" width="100%" data-pre-order='[[0,"desc"]]'>
<thead>
<tr>
	<th>เลขรับ</th>
	<th>งาน</th>
	<th>เจ้าของเรื่อง</th>
	<th>เรื่อง</th>
	<th>วันครบกำหนดแจ้งเตือน</th>
</tr>
</thead>
<tbody>
<?php 
  foreach($documents->result() as $document){ 
	//	$docYear = explode('/',$document->recieveDate)[2];
		//$docNum = $document->recieveNum."/".$docYear ;
?>
<tr id="<?= $document->id ?>">
	<td><?= ($document->year+543)."/".$document->recieveNum ?></td>
	<?php 
		$workname = $document->workName == null ? "ไม่ระบุ" : $document->workName ;	
		$workname .= $document->workID == 1 && $document->doctypeName != null ? "(".$document->doctypeName.")" : "";
		$workname .= $document->workID == 1 && $document->doctypeName == null ? "(ไม่ระบุ)" : "" ;
	?>
	<td><?=$workname ?></td>
	<td><?= $document->forName.$document->firstName ?></td>
	<td><?= $document->title ?></td>
	<td>
		<?php if( $document->success == 1) { echo "ดำเนินการแล้วเสร็จ"; }else{ ?>
		<?= $document->alarmStop == 1 ? "<del>".$document->alarmDate."</del>" : $document->alarmDate ?>
		<?php } ?>
	</td>
</tr>
<?php } ?>
</tbody>
</table>


<!---------------------------------------/body ------------------------------------------->


<!------------------------------------------modal ------------------------------------------->

<div id="add-new-item" class="modal fade" data-edit-mode="false" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">แบบบันทึกรายการ</h4>
      </div>
      <div class="modal-body">

				<ul class="nav nav-tabs">
  				<li class="active"><a href="#document" data-toggle="tab">เรื่อง/สั่งการ</a></li>
			 	<li><a href="#number" data-toggle="tab">เลขรับ</a></li>
			 	<li id='complaint-menu'><a href="#complaint_tab" data-toggle="tab" >ร้องเรียน</a></li>
			 	<li><a href="#location" data-toggle="tab" >บุคคล/ที่ตั้ง</a></li>
			 	<li><a href="#cert" data-toggle="tab" >ใบอนุญาต</a></li>
			 	<li><a href="#alarm" data-toggle="tab" >การแจ้งเตือน/ปิดงาน</a></li>
			 	<li id='insert-doc'><a href="#insert_doc" data-toggle="tab" >เอกสารแนบ</a></li>
		  		</ul>

				<div id="my-tab" class="tab-content">

				<div id="complaint_tab" class="tab-pane fade">

		   <div class="form-group">
			  <label for="comptypeID">ประเภทร้องเรียน</label>
				<select id="comptypeID" class="form-control">
					<?php foreach($comptypes->result() as $comptype): ?>
						<option value="<?= $comptype->comptypeID ?>"> <?= $comptype->comptypeName ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<div class="checkbox"> <label> <input id="command37" type="checkbox" > สั่ง37 </label> </div>
			</div>

			<ul class="nav nav-pills nav-justified">
						<li class="active"  ><a data-toggle='pill' href="#fact_tab" >ข้อเท็จจริง</a></li>
						<li><a data-toggle='pill' href="#operation_tab">ดำเนินการ</a></li>
						<li><a data-toggle='pill' href="#summary_tab">สรุปผล</a></li>
		    </ul>	



				<div id="ab-tab" class="tab-content">

					<div id="fact_tab" class="tab-pane fade in active">
						<div class="form-group">
							  <label for="fact">ข้อเท็จจิรง</label>
							  <textarea id="fact" type="text" class="form-control" rows="5"></textarea>
						</div>
					</div>

					<div id="operation_tab" class="tab-pane fade">
						<div class="form-group">
							  <label for="operation">การดำเนินการ</label>
							  <textarea id="operation" type="text" class="form-control" rows="5"></textarea>
						</div>
					</div>

					<div id="summary_tab" class="tab-pane fade">
						<div class="form-group">
							  <label for="summary">สรุปผล</label>
							  <textarea id="summary" type="text" class="form-control" rows="5"></textarea>
						</div>
					</div>

				</div>

	

					

				 </div>


				<div id="location" class="tab-pane fade">
						<div class="form-group">
							  <label for="contact-name">เรียน/ผู้ประกอบการ</label>
							  <input id="contact-name" type="text" class="form-control" ></input>
						</div>

						<div class="form-group">
							  <label for="contact-type">ประเภทบุคคล</label>
							  <select id="contact-type" class="form-control" >
							  	<option value="0">ไม่ระบุ</option>
							  	<option value="1">บุคคลธรรมดา</option>
							  	<option value="2">หจก.</option>
							  	<option value="3">บจก.</option>
							  </select>
						</div>

					<div  class="form-group">
							  <label for="contactDo">ประกอบกิจการ</label>
							  <input id="contactDo" type="text" class="form-control"></input>
					</div>
					 <div class="form-group">
						<label for="loc">ที่ตั้ง</label>
						 <textarea id="loc" type="text" class="form-control"  rows="2"></textarea>
					 </div>

					 <div class="form-group">
							  <label for="amphurID">อำเภอ</label>
							  <select id="amphurID" class="form-control" >
							  <?php foreach($amphurs->result() as $amphur): ?>
							  	<option value="<?= $amphur->amphurID ?>"><?= $amphur->amphurName ?></option>
							  <?php endforeach; ?>
							  </select>
					 </div>

				</div>

				<div id="cert" class="tab-pane fade">
						<div class="form-group">
							  <label for="certificateID">ใบอนุญาตเลขที่</label>
							  <input id="certificateID" type="text" class="form-control" ></input>
						</div>

						<div  class="regis-cert form-group" style="display:none">
							  <label for="certDate">วันที่ออกใบอนุญาต</label>
							  <input id="certDate" type="text" class="form-control" data-provide="datepicker" data-date-language="th-th"></input>
						</div>

						<div class="form-group">
							  <input id="regisCer" type="checkbox"></input>
							  <label for="regisCer">ออกใบอนุญาติ</label>
						</div>



				 </div>
	
				 <div id="insert_doc" class="tab-pane fade">

				 <div class="form-group">
				 <div id='inserted_files'>
				 	<ul></ul>
				 </div>
				 
				 <input id="upload_file" type="file" class="form-control" >
				 	<button id='upload-btn' class='btn btn-default'>อัปโหลด</button>
				 </div>

				 </div>
				
				<div id="alarm" class="tab-pane fade">
						<div class="checkbox">
						  <label>
							 <input id="alarmStop" type="checkbox" > ปิดการแจ้งเตือน
						  </label>
						</div>

					 <div class="form-group">
						 <label for="alarm-date">กำหนดวันแจ้งเตือน</label>
						 <input id="alarm-date" type="text" class="form-control"  data-provide="datepicker" data-date-language="th-th"></input>
					 </div>

						<div class="checkbox">
						  <label>
							 <input id="success" type="checkbox" > ดำเนินการแล้วเสร็จ
						  </label>
						</div>


				</div>

		  		 <div id="document" class="tab-pane fade in active">
				 
						 <div class="form-group">
							  <label for="document-name">เรื่อง</label>
							  <input id="document-name" type="text" class="form-control" ></input>
						 </div>

						<div class="form-group">
						 	<label for="sendDate">วันที่ส่งเรื่อง</label>
						 	<input id="sendDate" type="text" class="form-control"  data-provide="datepicker" data-date-language="th-th"></input>
					   </div>


						 <div class="form-group">
							  <label for="document-owner">เจ้าของเรื่อง</label>
							  <select id="document-owner" class="form-control">
							  <?php
									  foreach($persons->result() as $person){
										  echo "<option value='".$person->personID."'>".$person->forName."".$person->firstName."</option>" ;
									  }
							  ?>
								</select>
						  </div>

						
						  
						  <div class="form-group">
							  <label for="action-command">รูปแบบสั่งการ</label>
							  <select id="action-command" class="form-control">
							  <?php
									  foreach($actions->result() as $action){
										  echo "<option value='".$action->actionID."'>".$action->name."</option>" ;
									  }
							  ?>
								</select>
						  </div>

	 				<div class="form-group">
						<label for="commandText">ข้อความสั่งการ</label>
						 <textarea id="commandText" type="text" class="form-control"  rows="2"></textarea>
					 </div>



						
						
					</div><!-- /document -->

					<div id="number" class="tab-pane fade">	
						  <div class="form-group">
							  <label for="recieve-number">เลขที่รับฝ่ายโรงงาน</label>
							  <input id="recieve-number" type="text" class="form-control" ></input>
						  </div>

						  <div class="form-group">
							  <label for="recieve-date">วันที่ลงรับฝ่ายโรงงาน</label>
							  <input id="recieve-date" type="text" class="form-control"  data-provide="datepicker" data-date-language="th-th"></input>
						  </div>

						  <div class="form-group">
							  <label for="fa-recieve-number">เลขรับ</label>
							  <input id="fa-recieve-number" type="text" class="form-control" ></input>
						  </div>

						  <div class="form-group">
							  <label for="fa-recieve-date">วันที่ลงรับ</label>
							  <input id="fa-recieve-date" type="text" class="form-control"  data-provide="datepicker" data-date-language="th-th"></input>
						  </div>
			  	  </div><!-- /number -->
				</div><!-- /tab-content -->

      </div> <!-- /modal-body -->

      <div class="modal-footer">
        <button id='save-btn' type="button" class="btn btn-primary">บันทึก</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div><!-- /modal-footer -->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!------------------------------------------/modal------------------------------------------->
<!-- doctype modal -->
<div id="modal-doctype-item" class="modal fade" data-edit-mode="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">เลือกประเภทเอกสาร</h4>
      </div>
      <div class="modal-body">
	  <div class="form-group">
						 	<label for="work">กลุ่มงาน</label>
							  <select id="work" class="form-control">
							    <?php foreach($works->result() as $work): ?>
								 <option value="<?= $work->workID ?>"><?= $work->workName ?></option>
								 <?php endforeach; ?>
								</select>
						  </div>


				 
						  <div id="doctype-panel" class="form-group " style="display:none">
							  <label for="doctype">ประเภทเอกสาร</label>
							  <select id="doctype" class="form-control">
							  	<option value="0">กรุณาเลือกประเภทเอกสาร</option>
							    <?php foreach($doctypes->result() as $doctype): ?>
								 <option value="<?= $doctype->doctypeID ?>"><?= $doctype->doctypeName ?></option>
								 <?php endforeach; ?>
								</select>
						  </div>


     </div>
    <div class="modal-footer">
        <button id='ok-btn' type="button" class="btn btn-primary">ตกลง</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div><!-- /modal-footer -->


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
