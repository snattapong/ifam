<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker-thai.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.th.js") ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/se-1.2.2/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>
console.log("main/action script");

//initialized datatable
var table=$('#<?=$method?>-table').DataTable({
	select: true,
	responsive: true,
	info: false,
	bLengthChange: false,
	paging: false,

	buttons: [
		{  text: 'เพิ่ม',
		   className: 'btn-primary table-btn',
			action: function(){ 
				resetForm();
				$('#add-<?=$method?>').modal('show');	
			}
		},
		{  text : 'ลบ',
		   className: 'btn-danger table-btn',
			action : deleteSelectRow
		},
		{  text : 'แก้ไข',
		   className: 'btn-success table-btn',
			action : function(){
				var row= table.row('.selected');
				getSelectedInfo(row.id());
			}
		}

   ]
});

table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


table.on( 'select', function ( e, dt, type, indexes ) {
            console.log( table.rows( indexes ).data().toArray());
} );

$('#<?=$method?>-table tbody').on('dblclick', 'tr', function () {
	var row = table.row(this);
	row.select();	
	getSelectedInfo(row.id());	
} );


function resetForm(){
	$("input[type='text']").each(function(index,value){
		$(this).val(null);
	});
	$("select").each(function(){
		$(this).prop('selectedIndex',0);
	});
}



function getSelectedInfo(rowID){
  /* DO NOT CHANGE AREA Template [FOR COPY]*/
	var $dialog = $("#add-<?=$method?>") ;
	var get_url = "<?= site_url('command/get_'.$method) ?>" ;
	var id = "<?=$method?>ID" ; 
	var info = {} ;
	info[id] =  rowID ;
  /* END DO NOT CHANGE AREA */

	$.get(get_url, info , function(data){ 
			console.log(data);

			if(data.success == true){
				console.log(data);
				$('#action-name').val(data.name);
				$dialog.data('edit-mode',true);
				$dialog.modal('show');
			}else{
				alert("Cannot Get Data");
			}
		},"json"
	);
}

function deleteSelectRow(){
  /* DO NOT CHANGE AREA Template [FOR COPY]*/
	if( ! confirm("Confirm Delete") ){ 
			return ;
	}
	var row= table.row('.selected');
	var id = "<?=$method?>ID" ; 
	var info = {} ;
	info[id] = row.id();
	var delete_url = "<?= site_url('command/delete_'.$method) ?>" ;
  /* DO NOT CHANGE AREA */

	$.post(delete_url, info, function(data){ 
			if(data.success == true){
				row.remove().draw(false);
			}else{
				alert("Cannot Delete");
			}
		},"json"
	);
}

$('#save-btn').click(function(){
	/* DO NOT CHANGE AREA Template [FOR COPY]*/
	var $dialog = $("#add-<?=$method?>") ;
	var id = "<?=$method?>ID" ; 
	var update_url = "<?= site_url('command/update_'.$method) ?>";
	var add_url = "<?= site_url('command/add_'.$method) ?>";
	/* DO NOT CHANGE AREA */


	var info = { "name" : $('#action-name').val() } ;
	if( $dialog.data("edit-mode") == true){
	  alert("save in editmode");
	  info[id] = table.row('.selected').id(); 
	  $.post( update_url,info,function(data){
				 if(data.success == true){
					  $dialog.data("edit-mode", false);
					  $dialog.modal('hide');	
					  location.reload(true);
				  }else{
					  alert("Error");
					  console.log(data);
				  }
	  },"json");

	}else{
	  alert("save in insert mode");
			  $.post(add_url,info,function(data){
				  if(data.success == true){
					  $dialog.modal('hide');	
					  location.reload(true);
				  }else{
					  alert("Error");
					  console.log(data);
				  }
			  },"json");
	}
});

</script>
