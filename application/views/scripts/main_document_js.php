<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker-thai.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.th.js") ?>"></script>
<script src="<?= base_url("assets/moment/moment-with-locales.js") ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/se-1.2.2/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>
console.log("main/dashboard script");


//initialized datatable

var table=$('#document-table').DataTable({
	select: true,
	responsive: true,
	info: false,
	bLengthChange: false,
	ordering: false,
	columnDefs: [
		{ "width" : "50px" , "targets" : 0 },
		{ "width" : "150px" , "targets" : 1 },
		{ "width" : "150px" , "targets" : 2 },
		{ "width" : "150px" , "targets" : 4 },
	],
	columns: [
		null,
		null,
		null,
		null,
		null
	],
	buttons: [
		{  text: 'เพิ่ม',
		   className: 'btn-primary table-btn',
			action: function(){ 
					resetForm();
					$('#add-new-item').data("edit-mode","false");
					$('#insert-doc').hide();
					$('#modal-doctype-item')
						.modal({ keyboard: true, backdrop: 'static' })
						.modal('show');

					//$('#modal-doctype-item').modal('show');	
			}

		},
		{  text : 'ลบ',
		   className: 'btn-danger table-btn',
			action : deleteSelectRow
		},
		{  text : 'แก้ไข',
		   className: 'btn-success table-btn',
			action : getSelectedInfo
		},
		{  text : 'ปิดงาน',
		   className: 'btn-info table-btn',
			action : closeMultipleJob
		},

		{
			text : '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>',
			className: 'btn-warning table-btn',
			action : function(){
				$('#alarm-modal').modal("show");
			}
		}

   ]
});


table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


table.on( 'select', function ( e, dt, type, indexes ) {
            console.log( table.rows( indexes ).data().toArray());
} );


//certificate
$('#regisCer').change(function(){
	if($(this).is(":checked")){
		$('.regis-cert').show('slow');
	}else{
		$('.regis-cert').hide('slow');
	}
});
//end certifiate

//initialized datatable
<?php if($searchText !== null): ?>
table.search("<?= $searchText ?>").draw();
<?php endif; ?>


$('#work').change(function(){
	$('#doctype').val(0);
	var workID= $(this).val();
	var doctypeID= $('#doctype').val();
	if(workID != 1){
		$('#doctype-panel').hide('slow');
	}else{
		$('#doctype-panel').show('slow');
	}

	$.get('<?= site_url("command/getAlarmDate")?>', { workID : workID, doctypeID : doctypeID }, function(data){
		  if(data.success == true){
		  	 console.log(1);
			 $('#alarm-date').val(data.alarmDate);
			console.log("alarm-date setted");
		  }
	},"json");	

});

$('#doctype').change(function(){
	var workID= $('#work').val();
	var doctypeID= $(this).val();

	$.get('<?= site_url("command/getAlarmDate")?>', { workID : workID, doctypeID : doctypeID }, function(data){
					  if(data.success == true){
		  	 			  console.log(2);
						  $('#alarm-date').val(data.alarmDate);
							console.log("alarm-date setted");
					  }
	},"json");	

});

$('#ok-btn').click(function(){

				$('#modal-doctype-item').modal('hide');	
				if( $('#work').val() == 2){ // for complaint menu display
				  $('#complaint-menu').show();	
				}else{
				  $('#complaint-menu').hide();	
				}

			   if( $('#add-new-item').data("edit-mode") == "false"){ 
						  alert(false);

						  $.get("<?=site_url('command/newDocumentInfo')?>",function(data){
							  if(data.success == true){
								  $('#recieve-number').val(data.recieveNum);
								  $('#recieve-date').val(data.recieveDate);
								  //$('#alarm-date').val(data.alarmDate);
							  }
							  else{
								  $('#recieve-number').val(99999);
								  var mm = new Date();
								  var now = mm.getDate()+"/"+(mm.getMonth()+1)+"/"+ ( mm.getFullYear()+ 543 );
								  $('#recieve-date').val(now);
							  }
							  $('#insert-doc').hide();
							  $('#add-new-item')
								.modal({ keyboard: true, backdrop: 'static' })
							  .modal('show');	
						  },"json");
				}
				else{
					  alert(true);
					console.log("YAH");
					$('#insert-doc').show();
				   $('#add-new-item')
					.modal({ keyboard: true, backdrop: 'static' })
					.modal('show');	
				}

});


function resetForm(){
	$("input[type='text']").each(function(index,value){
		$(this).val(null);
	});
	$("select").each(function(){
		$(this).prop('selectedIndex',0);
	});
	$("input[type='checkbox']").each(function(){
		$(this).prop('checked',false);
	});
}

$('#upload-btn').on('click', function() {
    var file_data = $('#upload_file').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
	 form_data.append('documentID',table.row('.selected').id()); 
    $.ajax({
                url: '<?= site_url('command/upload') ?>', // point to server-side PHP script 
                dataType: 'json',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(data){
					 	console.log(data);
						if(data.success == true){
								  var html = "<li><a href='<?=base_url('uploads')?>/"+data.upload_data.file_name+"' target='_blank'>";
								  html+= data.upload_data.orig_name+"</a>";
								  html +="<a class='delete-file' data-id='"+data.fileID+"' href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> </li>";
								  html+= "</li>"
								  console.log(html);
								  $('#inserted_files ul').append(html);
								  alert('อัปโหลดสำเร็จ');
						}else{
								  alert(data.message);
						}
                }
     });
});

$('#inserted_files').on('click','.delete-file',function(){
	var fileID= $(this).data("id");
	var that = this ;
	 if( confirm( "ท่านต้องการลบไฟล์ ใช่หรือ่ไม่ ?" )){
		  $.post('<?= site_url('command/deleteFile') ?>'
		  , { fileID : fileID }
		  ,function(data){
		  	if(data.success == true){
				alert("ลบไฟล์สำเร็จ");
				var ul = that.parentNode;
				ul.parentNode.removeChild(ul);
			}else{
				alert("เกิดข้อผิดพลาด ไม่สามารถลบไฟล์ได้");
			}
		  },"json");
	 }
	 	 
});



$('#document-table tbody').on('dblclick', 'tr', function () {
	var row = table.row(this);
	row.select();	
	getSelectedInfo(row.id());	
} );

function closeJob(){
	var row= table.row('.selected');
	$.post('<?= site_url('command/closeJob') ?>', { documentID : row.id() },
			function(data){ 
				if(data.success == true){ 
					alert("ปิดงานสำเร็จ"); 
					table.cell(table.row('.selected'),4).data("ดำเนินการแล้วเสร็จ");
				}
			},"json"
	);
}


function closeMultipleJob(){
	$.post('<?= site_url('command/closeMultipleJob') ?>', { ids : table.rows('.selected').ids().toArray() },
			function(data){ 
				if(data.success == true){ 
					table.rows('.selected').every(function(rowIdx,tableLoop,rowLoop){
						table.cell(this,4).data("ดำเนินการแล้วเสร็จ");
					});
					alert("ปิดงานสำเร็จ"); 
				}
			},"json"
	);
}

function getSelectedInfo(){
	var row= table.row('.selected');
	$.get('<?= site_url('command/getDocument') ?>', { documentID : row.id() },
		function(data){ 
			if(data.success == true){
				//row.remove().draw(false);
				console.log(data);

		 		$('#recieve-number').val(data.recieveNum);
				$('#recieve-date').val(data.recieveDate);
				$('#fa-recieve-number').val( data.factory_recieveNum == 0 ? null : data.factory_recieveNum );
				$('#fa-recieve-date').val(data.factory_recieveDate);
				$('#document-owner').val(data.owner );
				$('#alarm-date').val(data.alarmDate);
				$('#document-name').val(data.title);
				$('#contact-name').val(data.contactName);
				$('#contact-type').val(data.contactType);
				$('#action-command').val(data.actionID == null ? 0 : data.actionID );
				$('#commandText').val(data.commandText);
				$('#sendDate').val(data.sendDate);
				$('#alarmStop').prop("checked",data.alarmStop == 1);
				$('#complaint').val(data.complaint);
				$('#command37').prop("checked",data.command37 == 1);
				$('#regisCer').prop("checked",data.regisCer == 1);
				if(data.regisCer == 1){
					$('.regis-cert').show();
				}else{
					$('.regis-cert').hide();
				}



				$('#success').prop("checked",data.isSuccess == 1);
				$('#contactDo').val(data.contactDo);
				$('#certDate').val(data.certDate);

				$('#certificateID').val(data.certificateID);
				$('#loc').val(data.location);
				$('#amphurID').val(data.amphurID);

 			$('#comptypeID').val(data.comptypeID);
		   $('#fact').val(data.fact);
			$('#summary').val(data.summary);
			$('#operation').val(data.operation);

				$('#inserted_files').empty();
				var html="<ul>";
		      $.each(data.files,function(k,v){
					console.log(k+":"+v);
					html +="<li><a href='<?=base_url('uploads')?>/"+v.file_name+"' target='_blank'>"+v.orig_name+"</a>";
					html +="<a class='delete-file' data-id='"+v.fileID+"' href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> </li>";
				});
				html+="</ul>";
				$('#inserted_files').append(html);


				
				$('#work').val(data.workID == null ? 0 : data.workID );
				$('#doctype').val(data.doctypeID == null ? 0 : data.doctypeID );
				if(data.workID != 1){
					$('#doctype-panel').hide('slow');
				}else{
					$('#doctype-panel').show('slow');
				}

				$('#add-new-item').data("edit-mode","true");
				$('#insert-doc').show();
				//$('#add-new-item').modal('show');
			

				$('#modal-doctype-item')
				.modal({ keyboard: true, backdrop: 'static' })
				.modal('show');	
			}else{
				alert("Cannot Get Data");
			}
		},"json"
	);
}

function deleteSelectRow(){
	if( ! confirm("Confirm Delete") ){ 
			return ;
	}
	var row= table.row('.selected');
	$.post('<?= site_url('command/deleteDocument') ?>', { documentID : row.id() },
		function(data){ 
			if(data.success == true){
				row.remove().draw(false);
			}else{
				alert("Cannot Delete");
			}
		},"json"
	);
}

$('#sendDate').datepicker({
    maxViewMode: 3,
    autoclose: true,
});

$('#certDate').datepicker({
    maxViewMode: 3,
    autoclose: true
});

$('#recieve-date').datepicker({
    maxViewMode: 3,
    autoclose: true,
});

$('#fa-recieve-date').datepicker({
    maxViewMode: 3,
    autoclose: true,
});

$('#alarm-date').datepicker({
    maxViewMode: 3,
    autoclose: true,
});

$('#save-btn').click(function(){
	console.log('submit form');

	var recieveDate = $('#recieve-date').val();
	var tmp;
	if( recieveDate != "" ){
		tmp = recieveDate.split("/");
		recieveDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}
   var factory_recieveDate = $('#fa-recieve-date').val();
	if( factory_recieveDate != "" ){
		tmp = factory_recieveDate.split("/");
		factory_recieveDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}

   var alarmDate = $('#alarm-date').val();
	if( alarmDate != "" ){
		tmp = alarmDate.split("/");
		alarmDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}

	var sendDate = $('#sendDate').val();
	if( sendDate != "" ){
		tmp = sendDate.split("/");
		sendDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}


	var certDate = $('#certDate').val() ;
	if( certDate != "" ){
		tmp = certDate.split("/");
		certDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}

	var commandText = $('#commandText').val();
	var info = {
		recieveNum : $('#recieve-number').val(),
		recieveDate : recieveDate,
		factory_recieveNum : $('#fa-recieve-number').val(),
		factory_recieveDate : factory_recieveDate,
		owner : $('#document-owner').val(),
		alarmDate : alarmDate,
		title : $('#document-name').val(),
		contactName : $('#contact-name').val(),
		contactType : $('#contact-type').val(),
		actionID: $('#action-command').val(),
		sendDate: sendDate,
		commandText: $('#commandText').val(),
		alarmStop: $('#alarmStop').is(':checked') ?  1 : 0 ,
		certificateID: $('#certificateID').val(),
		loc : $('#loc').val(),
		amphurID : $('#amphurID').val(),
		workID : $('#work').val(),
		doctypeID : $('#doctype').val(),
		command37 : $('#command37').is(':checked') ?  1 : 0 ,
		regisCer : $('#regisCer').is(':checked') ?  1 : 0 ,
		contactDo : $('#contactDo').val(),
		certDate : certDate ,
		success : $('#success').is(':checked') ?  1 : 0 ,
		comptypeID : $('#comptypeID').val(),
		fact : $('#fact').val(),
		summary : $('#summary').val(),
		operation : $('#operation').val(),
	};
	console.log(info);

	if( $('#add-new-item').data("edit-mode") == "true"){
	  info["documentID"] = table.row('.selected').id(); 

	  $.post("<?= site_url('command/updateDocument') ?>",info,function(data){
				 if(data.success == true){
					  $('#add-new-item').data("edit-mode", "false");
					  $('#add-new-item').modal('hide');	
					  //location.reload(true);
						table.cell(table.row('.selected'),1).data($('#work option:selected').text());
				  }else{
					  alert("Error");
					  console.log(data);
				  }
	  },"json");

		}else{

			  $.post("<?= site_url('command/newDocument') ?>",info,function(data){
				  if(data.success == true){
					  $('#add-new-item').modal('hide');	
					  window.location = "<?= site_url('main/document') ?>";
				  }else{
					  alert("Error");
					  console.log(data);
				  }
			  },"json");
	}
});

//hide all datepicker
$('#add-new-item').on("hide.bs.modal",function(){
	
	$('#sendDate').datepicker('hide'); 
	$('#recieve-date').datepicker('hide');
	$('#fa-recieve-date').datepicker('hide'); 
	$('#alarm-date').datepicker('hide');
		
});

$('.work-info').click(function(){
	console.log('clicked');
});

function popAlarm(item){
	$('.alarm-pop').not(item).popover('destroy');
	 $.get("<?= site_url('command/getWorkloadInfo') ?>",{ owner : $(item).data('id') }, function(data){ 
			  $(item).popover({
					 trigger: 'manual',
					 placement: 'right',
					 html: true,
					 delay: { "show": 500, "hide": 100 } ,
					 content: function() {
						 return data.html;
					 }
				});
				$(item).popover("show");

	 },"json");

}

function flipAlarm(item){
	 $.get("<?= site_url('command/getWorkloadInfo') ?>",{ owner : $(item).data('id') }, function(data){ 
	 		$("#workload-front").hide();
			console.log(data.html);
			$("#workload-back").html(data.html);
			$("#workload-back").show();
	 },"json");
}

function flip(){

		$('#workload-back').toggle();		
	 	$("#workload-front").toggle();
}

function showInfo(documentID){
	$.get('<?= site_url('command/getDocument') ?>', { documentID : documentID },
		function(data){ 
			if(data.success == true){
				$('#alarm-modal').modal('hide');
				console.log(data);
		 		$('#recieve-number').val(data.recieveNum);
				$('#recieve-date').val(data.recieveDate);
				$('#fa-recieve-number').val( data.factory_recieveNum == 0 ? null : data.factory_recieveNum );
				$('#fa-recieve-date').val(data.factory_recieveDate);
				$('#document-owner').val(data.owner );
				$('#alarm-date').val(data.alarmDate);
				$('#document-name').val(data.title);
				$('#contact-name').val(data.contactName);
				$('#contact-type').val(data.contactType);
				$('#action-command').val(data.actionID == null ? 0 : data.actionID );
				$('#commandText').val(data.commandText);
				$('#sendDate').val(data.sendDate);
				$('#alarmStop').prop("checked",data.alarmStop == 1);
				$('#certificateID').val(data.certificateID);
				$('#loc').val(data.location);
				$('#amphurID').val(data.amphurID);
				$('#complaint').val(data.complaint);
				$('#command37').prop("checked",data.command37 == 1);
				$('#regisCer').prop("checked",data.regisCer == 1);

				if(data.regisCer == 1){
					$('.regis-cert').show();
				}else{
					$('.regis-cert').hide();
				}

				$('#contactDo').val(data.contactDo);
				$('#certDate').val(data.certDate);

				$('#success').prop("checked",data.isSuccess == 1);

 			$('#comptypeID').val(data.comptypeID);
		   $('#fact').val(data.fact);
			$('#summary').val(data.summary);
			$('#operation').val(data.operation);
				
				$('#work').val(data.workID == null ? 0 : data.workID );
				$('#doctype').val(data.doctypeID == null ? 0 : data.doctypeID );

				$('#inserted_files').empty();
				var html="<ul>";
		      $.each(data.files,function(k,v){
					console.log(k+":"+v);
					html +="<li><a href='<?=base_url('uploads')?>/"+v.file_name+"' target='_blank'>"+v.orig_name+"</a>";
					html +="<a class='delete-file' data-id='"+v.fileID+"' href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a> </li>";
				});
				html+="</ul>";
				$('#inserted_files').append(html);


		     
				if(data.workID != 1){
					$('#doctype-panel').hide('slow');
				}else{
					$('#doctype-panel').show('slow');
				}

				$('#add-new-item').data("edit-mode","true");
				$('#insert-doc').show();
				$('#modal-doctype-item')
				.modal({ keyboard: true, backdrop: 'static' })
				.modal('show');	
			}else{
				alert("Cannot Get Data");
			}
		},"json"
	);

}

$('document').on('click','#alarm-back-btn',function(){
		console.log("HEY");
		$('#workload-back').toggle();		
	 	$("#workload-front").toggle();
});

$('.alarm-pop').click(function(e){
	//popAlarm(this);
	flipAlarm(this);
});

//alarm
<?php if( $hasAlarm ): ?> 
	$('#alarm-modal').modal("show");

<?php endif; ?>
	$('#alarm-modal').on("hide.bs.modal",function(){
		$('.alarm-pop').popover('destroy');
	});

$('#memAlarm').change(function(){
	var remember = $(this).is(":checked");
	$.post('<?=site_url("command/setAlarmRemember")?>', { remember : remember == true ? 1 : 0  } ,function(data){
		if(data.success){
			  if(remember){
				  console.log("การจำถูกบันทึก จะไม่มีการเตือนอีก ภายในวันนี้");
			  }else{
				  console.log("ยกเลิกการจำถูกบันทึก ระบบการเตือนจะยังคงอยู่ ");
			  }
		}else{
				  alert("ขออภัย ไม่สามารถบันทึกข้อมูลลงในระบบ");
		}
	 },"json");
 });

//speed
$('#speed').change( function(){
	$.get('<?= site_url("command/getAlarmDate")?>', { speedValue : $('#speed').val() }, function(data){
			if(data.success == true){
				$('#alarm-date').val(data.alarmDate);
			}
	},"json");	
});


</script>
