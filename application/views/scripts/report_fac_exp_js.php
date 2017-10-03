<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker-thai.js") ?>"></script>
<script src="<?= base_url("assets/datepicker/bootstrap-datepicker.th.js") ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/se-1.2.2/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>
console.log("report/fac_exp script");

var table=$('#<?=$method?>-table').DataTable({
	responsive: true,
	bLengthChange: false,
	'dom': 'Bfrltip',
	order: [ [0,'desc']],
	buttons: [
		{  text: 'วันที่แจ้งยกเลิก',
		   className: 'btn-primary table-btn',
			action: function(){ 
				$('#date-filter').modal('show');	
			}
		},
		{  text: 'RESET',
		   className: 'btn-primary table-btn',
			action: function(){ 
				table.ajax.url( '<?= site_url('command/getRequestExpFactories') ?>' ).load();
			}
		}
   ],
	ajax : "<?= site_url('command/getRequestExpFactories') ?>",
	rowId : 'id',
	columns : [ 
		{ title : "เลขที่", data : "documentNum" },	
		{ title : "ชื่อโรงงาน", data : "contactName" },	
		{ title : "ทะเบียนอนุญาต", data : "certificateID" },	
		{ title : "ที่ตั้ง", data : "location" },	
		{ title : "ประกอบธุรกิจ", data : "contactDo" }	
	],

});

table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


table.on( 'select', function ( e, dt, type, indexes ) {
            console.log( table.rows( indexes ).data().toArray());
} );

$('#<?=$method?>-table tbody').on('dblclick', 'td', function () {
	//alert(row.id());	
	var cell=table.cell(this);
	if(cell.index().column==0)
		window.open( "<?=site_url('main/document')?>?q="+cell.data() );
} );




function resetForm(){
	$("input[type='text']").each(function(index,value){
		$(this).val(null);
	});
	$("select").each(function(){
		$(this).prop('selectedIndex',0);
	});
}

$('#fromDate').datepicker({
    maxViewMode: 3,
    autoclose: true,
});

$('#toDate').datepicker({
    maxViewMode: 3,
    autoclose: true
});



$('#filter-btn').click(function(){
	var tmp;


   var toDate = $('#toDate').val();
	if( toDate != "" ){
		tmp = toDate.split("/");
		toDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}

	var fromDate = $('#fromDate').val();
	if( fromDate != "" ){
		tmp = fromDate.split("/");
		fromDate = (tmp[2]-543)+"-"+tmp[1]+"-"+tmp[0] ; 
	}

	table.ajax.url( '<?=site_url('command/getExpFacBetween')?>/'+fromDate+'/'+toDate ).load();
});



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
				$('#speedName').val(data.speedName);
				$('#speedValue').val(data.speedValue);
				$dialog.data('edit-mode',true);
				$dialog.modal('show');
			}else{
				alert("Cannot Get Data");
			}
		},"json"
	);
}

</script>
