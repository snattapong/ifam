<script src="<?= base_url("assets/moment/moment-with-locales.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<script src="<?= base_url("assets/Chart.PieceLabel.min.js") ?>"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- google chart -->
<script>

// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(initialChart);


function checkPermissionInfo(chart,dataTable){
	var selectItem = chart.getSelection()[0];
	console.log( dataTable.getValue(selectItem.row,0));
	console.log( dataTable.getValue(selectItem.row,1));
	console.log( dataTable.getValue(selectItem.row,2));
	var doctypeID= dataTable.getValue(selectItem.row,2);
	var label = dataTable.getValue(selectItem.row,0);
	var query = "งานอนุญาต("+label+")" ; 
	var qtext = $('#main-chart').data("uid") == 0 ? "" : $('#chart-label').html() ;
	var url = "<?=site_url('main/document')?>?q="+qtext+" "+query; 
		//window.location= url ;
	window.open(url) ;

}

function checkInfo(chart,dataTable){
	var selectItem = chart.getSelection()[0];
	console.log( dataTable.getValue(selectItem.row,0));
	console.log( dataTable.getValue(selectItem.row,1));
	console.log( dataTable.getValue(selectItem.row,2));
	var doctypeID= dataTable.getValue(selectItem.row,2);
	var label = dataTable.getValue(selectItem.row,0);
	var qtext = $('#main-chart').data("uid") == 0 ? "" : $('#chart-label').html() ;
	var url = "<?=site_url('main/document')?>?q="+qtext+" "+label; 
		//window.location= url ;
	window.open(url) ;

}


function drawFactoryChart(){
		//get-Permission-Anually Workload
		$.get('<?= site_url('command/getPAW/2017')?>',function(data){
				  var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string','งาน');
					dataTable.addColumn('number','จำนวน');
					dataTable.addColumn('number','ID');
					// Instantiate and draw our chart, passing in some options.
					$.each(data,function(i,row){
						 dataTable.addRow( [ row[0] , parseInt(row[1]),parseInt(row[2]) ]);
					});

				  var chart = new google.visualization.PieChart(document.getElementById('main-chart'));
				  var options = { 'title' : 'งานอนุญาตประจำปี 2560' , pieHole : 0.3 , legend : "right" };
				  google.visualization.events.addListener(chart, 'select', function(){ checkPermissionInfo(chart,dataTable) ; } );
				  chart.draw( dataTable, options );
		},"json");

		//get-Department Anually-Workload
		$.get('<?= site_url('command/getDAW/2017')?>',function(data){
				  var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string','งาน');
					dataTable.addColumn('number','จำนวน');
					dataTable.addColumn('number','ID');
					dataTable.addColumn({type:'string', role:'annotation'});
					
					// Instantiate and draw our chart, passing in some options.
					$.each(data,function(i,row){
						 dataTable.addRow( [ row[0] , parseInt(row[1]),  parseInt(row[1]),  row[1] ]  );
					});

				  var view = new google.visualization.DataView(dataTable);
				  view.hideColumns([2]);
				  var chart = new google.visualization.ColumnChart(document.getElementById('sub-chart'));
				  google.visualization.events.addListener(chart, 'select', function(){ checkInfo(chart,dataTable) ; } );
				  var options = { 'title' : 'ภาพรวมงานประจำปี 2560' , legend : "none" };
				  chart.draw( view, options );
		 },"json");

	currentChart = "factory";
	console.log("Factory Drawed");
}

function drawPersonChart(uid,year){
		//get-Staff Permission-Anually Workload
		$.get('<?= site_url('command/getSPAW')?>/'+uid+'/'+year,function(data){
				  var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string','งาน');
					dataTable.addColumn('number','จำนวน');
					dataTable.addColumn('number','ID');
					// Instantiate and draw our chart, passing in some options.
					$.each(data,function(i,row){
						 dataTable.addRow( [ row[0] , parseInt(row[1]),parseInt(row[2]) ]);
					});

				  var chart = new google.visualization.PieChart(document.getElementById('main-chart'));
				  var options = { 'title' : 'งานอนุญาตประจำปี 2560' , pieHole : 0.3 , legend : "right" };
				  //google.visualization.events.addListener(chart, 'select', function(){ checkInfo(dataTable) ; } );
				  google.visualization.events.addListener(chart, 'select', function(){ checkPermissionInfo(chart,dataTable) ; } );
				  chart.draw( dataTable, options );
		},"json");

		//get-Staff Anually-Workload
		$.get('<?= site_url('command/getSAW')?>/'+uid+'/'+year,function(data){
				  //console.log(data);
				  var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string','งาน');
					dataTable.addColumn('number','จำนวน');
					dataTable.addColumn({type:'string', role:'annotation'});
					// Instantiate and draw our chart, passing in some options.
					$.each(data,function(i,row){
						 dataTable.addRow( [ row[0] , parseInt(row[1]),  row[1] ]  );
					});

				  var chart = new google.visualization.ColumnChart(document.getElementById('sub-chart'));
				  var options = { 'title' : 'ภาพรวมงานประจำปี 2560' , legend : "none" };
				  google.visualization.events.addListener(chart, 'select', function(){ checkInfo(chart,dataTable) ; } );
				  chart.draw( dataTable, options );
		 },"json");

	currentChart = "person";
   console.log("Person Drawed");
}




function initialChart(){
	drawFactoryChart();
}

function drawCurrentChart(){
	var uid = $('#main-chart').data("uid");
	if( uid == 0 ) 
		drawFactoryChart();
	else
		drawPersonChart(uid,2017);
	/*
	if(currentChart == "factory"){
		drawFactoryChart();
	}else{
		drawPersonChart();
	}*/

}

$(window).resize(function(){
	drawCurrentChart();
});

</script>


<script>
console.log("main/dashboard script");

//random
<?php 
/*
$.ajax({
  url: 'https://randomuser.me/api/?inc=gender,picture&results=300',
  dataType: 'json',
  success: function(data) {
  	 var results = data.results;
	 var html = "";
	 var index = 0;
	 var r =0;

	 var pictures=[];

	 var gender = "";

	 <?php $count = 0; 
	 foreach($persons->result() as $person ){ 
	 	 if($count++ == 0) continue;
	 ?>
	 	gender = "<?= $person->gender ?>" ;
		var same = false;
		while(true){
			r= Math.floor((Math.random()*300)) ;
			if( results[r].gender == gender ){
			   break; 
			}
		}
	 	pictures[index++] = results[r].picture.medium ; 
	 <?php } ?>
	
	 // console.log(pictures);
		 r= Math.floor((Math.random()*300)) ;
 		 html = "<div class='col-sm-12 col-xs-12 col-md-6'><div class='thumbnail'>";
		 html += "<img class='all-person' src='"+ results[r].picture.medium +"'>";
		 html += "<div class='caption text-center'>หน่วยงาน</div></div></div>";	
		$('#person-panel').append( html);


	  index = 0;

	 <?php $count = 0 ; foreach($persons->result() as $person){  
	 	 if($count++ == 0) continue;
	 ?>
	 	 html = "<div class='col-sm-12 col-xs-12 col-md-6'><div class='thumbnail'>";
		 html += "<img class='person' src='"+ pictures[index]+"' data-id='<?= $person->personID ?>' data-name='<?= $person->firstName ?>'>";
		 html += "<div class='caption text-center'><?= $person->forName.$person->firstName ?></div></div></div>";	
		$('#person-panel').append( html);
		index++ ;
	  <?php } ?>

  }
});
*/
?>




//chart.js

var personalChart;
var ctx;
var chart;

function drawRemainPersonChart(component){

		$.get('<?= site_url('command/getPersonWorkLoad') ?>'
		, { personID : $(component).data("id") }
		,function(data){
				if( chart){
				  chart.destroy();
				}
				ctx = document.getElementById("myChart").getContext('2d');

				//var chartLabel= [ "a","b","c" ];
				//var chartData = [ 10,20,30 ] ;
				//var chartColor = [ "#2ecc71", "#95a5a6", "#f1c40f" ];

				var chartLabel = data.chartLabel;
				var chartData  = data.chartData;
				var chartColor = data.chartColor;

				chart = new Chart(ctx, {
						type: 'pie',
						data: {
						 labels: chartLabel,
						  datasets: [ { backgroundColor: chartColor, data: chartData } ]
						},
						pieceLabel: {
							 // mode 'label', 'value' or 'percentage', default is 'percentage'
							 mode: 'percentage',

							 // precision for percentage, default is 0
							 precision: 0,
							 
							 //identifies whether or not labels of value 0 are displayed, default is false
							 showZero: true,

							 // font size, default is defaultFontSize
							 fontSize: 12,

							 // font color, default is '#fff'
							 fontColor: '#fff',

							 // font style, default is defaultFontStyle
							 fontStyle: 'normal',

							 // font family, default is defaultFontFamily
							 fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

							 // draw label in arc, default is false
							 arc: true,

							 // position to draw label, available value is 'default', 'border' and 'outside'
							 // default is 'default'
							 position: 'default',

							 // format text, work when mode is 'value'
							 format: function (value) { 
								return '$' + value;
							}
					}
			  	});
	
		}
		,"json"
	);
}

function drawAllRemainPersonChart(){

		$.get('<?= site_url('command/getAllPersonWorkLoad') ?>'
		, { personID : $(this).data("id") }
		,function(data){
				if( chart){
				  chart.destroy();
				}
				ctx = document.getElementById("myChart").getContext('2d');
				var chartLabel = data.chartLabel;
				var chartData  = data.chartData;
				var chartColor = data.chartColor;
				chart = new Chart(ctx, {
						type: 'pie',
						responsive: true,
        				maintainAspectRatio: false,
						data: {
						  labels: chartLabel,
						  datasets: [ { backgroundColor: chartColor, data: chartData } ]
						},
						pieceLabel: {
						  mode: 'value',
						  fontSize: 14,
    					  fontStyle: 'bold'
					   }
			  });
	
		}
		,"json"
	);

}

function drawPersonWorkloadChart(component){

	$.get('<?= site_url('command/getPersonWorkloadFull') ?>'
		, { personID : $(component).data("id") }
		,function(data){
				if( chart){
				  chart.destroy();
				}
				ctx = document.getElementById("myChart").getContext('2d');
				var chartLabel = data.chartLabel;
				var chartData  = data.chartData;
				var chartColor = data.chartColor;
				chart = new Chart(ctx, {
						type: 'pie',
						data: {
						 labels: chartLabel,
						  datasets: [ { backgroundColor: chartColor, data: chartData } ]
						},
						pieceLabel: {
							 // mode 'label', 'value' or 'percentage', default is 'percentage'
							 mode: 'percentage',

							 // precision for percentage, default is 0
							 precision: 0,
							 
							 //identifies whether or not labels of value 0 are displayed, default is false
							 showZero: true,

							 // font size, default is defaultFontSize
							 fontSize: 12,

							 // font color, default is '#fff'
							 fontColor: '#fff',

							 // font style, default is defaultFontStyle
							 fontStyle: 'normal',

							 // font family, default is defaultFontFamily
							 fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

							 // draw label in arc, default is false
							 arc: true,

							 // position to draw label, available value is 'default', 'border' and 'outside'
							 // default is 'default'
							 position: 'default',

							 // format text, work when mode is 'value'
							 format: function (value) { 
								return '$' + value;
							}
					}

			  });
	
		}
		,"json"
	);

}

function drawAllWorkloadChart(){
	$.get('<?= site_url('command/getWorkLoadAll') ?>'
		, function(data){
				if( chart){
				  chart.destroy();
				}
				ctx = document.getElementById("myChart").getContext('2d');
				var chartLabel = data.chartLabel;
				var chartData  = data.chartData;
				var chartColor = data.chartColor;
				chart = new Chart(ctx, {
						type: 'pie',
						data: {
						 labels: chartLabel,
						  datasets: [ { backgroundColor: chartColor, data: chartData } ]
						},
						pieceLabel: {
							 // mode 'label', 'value' or 'percentage', default is 'percentage'
							 mode: 'percentage',

							 // precision for percentage, default is 0
							 precision: 0,
							 
							 //identifies whether or not labels of value 0 are displayed, default is false
							 showZero: true,

							 // font size, default is defaultFontSize
							 fontSize: 12,

							 // font color, default is '#fff'
							 fontColor: '#fff',

							 // font style, default is defaultFontStyle
							 fontStyle: 'normal',

							 // font family, default is defaultFontFamily
							 fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

							 // draw label in arc, default is false
							 arc: true,

							 // position to draw label, available value is 'default', 'border' and 'outside'
							 // default is 'default'
							 position: 'default',

							 // format text, work when mode is 'value'
							 format: function (value) { 
								return '$' + value;
							}
					}

			  });
	
		}
		,"json"
	);

}



$('#myChart').click(function (evt) {
      var activePoints = chart.getElementsAtEvent(evt);
      var chartData = activePoints[0]['_chart'].config.data;
      var idx = activePoints[0]['_index'];

      var label = chartData.labels[idx];
      var value = chartData.datasets[0].data[idx];

      var url = "<?=site_url('main/document')?>?q="+label+" "+$(this).data("qtext"); 
		//window.location= url ;
		window.open(url) ;

 });

$('body').on('click','.person', function(){
	//$('#all-work-btn').data("id",$(this).data("id") );
	//$('#remain-work-btn').data("id",$(this).data("id") );
	//$('#myChart').data("qtext",$(this).data("name"));
 	//drawRemainPersonChart(this);
	$('#main-chart').data("uid",$(this).data("id") );
	$('#chart-label').html($(this).data("name"));
	drawCurrentChart();
 });

/*
$('body').on('click','.all-person',function(){
	//$('#all-work-btn').data("id", 0 );
	//$('#remain-work-btn').data("id",0 );
	//$('#myChart').data("qtext","");
  	//drawAllRemainPersonChart();
	$('#main-chart').data("uid",$(this).data("id") );
	$('#chart-label').html($(this).data("name"));
	drawCurrentChart();
 });
 */

$('#all-work-btn').click( function(){ 
  if( $(this).data("id") == 0 ){
		drawAllWorkloadChart()
  }else{
 		drawPersonWorkloadChart(this);
  }
});

$('#remain-work-btn').click(function(){ 
  if( $(this).data("id") == 0 ){
		drawAllRemainPersonChart();
  }else{
 		drawRemainPersonChart(this);
  }
});

//drawAllRemainPersonChart();
//end chart.js


//initialized datatable

function getSelectedInfo(){
	var row= table.row('.selected');
	$.get('<?= site_url('command/getDocument') ?>', { documentID : row.id() },
		function(data){ 
			if(data.success == true){
				//row.remove().draw(false);
				console.log(data);

		 		$('#recieve-number').val(data.recieveNum);
				$('#recieve-date').val(data.recieveDate);
				$('#fa-recieve-number').val(data.factory_recieveNum);
				$('#fa-recieve-date').val(data.factory_recieveDate);
				$('#document-owner').val(data.owner );
				$('#alarm-date').val(data.alarmDate);
				$('#document-name').val(data.title);
				$('#contact-name').val(data.contactName);
				$('#action-command').val(data.actionID);
				$('#commandText').val(data.commandText);
				$('#sendDate').val(data.sendDate);
				$('#alarmStop').prop("checked",data.alarmStop == 1);
				$('#add-new-item').data("edit-mode","true");
				$('#add-new-item').modal('show');
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

$('#workload-back').click(function(){
		$(this).toggle();		
	 	$("#workload-front").toggle();
});

$('.alarm-pop').click(function(e){
	//popAlarm(this);
	flipAlarm(this);
});

//alarm

<?php if( $hasAlarm ): ?> 
 //	$('#alarm-modal').modal("show");
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



</script>
