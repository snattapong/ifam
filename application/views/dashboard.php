<div class="col-md-4 col-sm-4 col-xs-4"> 
	<div id="person-panel">

	 	<div class='col-sm-12 col-xs-12 col-md-6'>
				  <div class='thumbnail'>
				  <img class='person' src='<?= base_url("avatars/factory.png") ?>' data-id='0' data-name='หน่วยงาน'>
				  <div class='caption text-center'>หน่วยงาน</div>
				  </div>
		</div>	
		<?php $count=0; ?>
     <?php foreach($persons->result() as $person): ?>
	  			<?php if($count++ == 0) continue; ?>
				  <div class='col-sm-12 col-xs-12 col-md-6'>
							 <div class='thumbnail'>
							 <img class='person' src='<?= base_url("avatars/".$person->avatar)?>' data-id='<?= $person->personID ?>' data-name='<?= $person->forName.$person->firstName ?>'>
							 <div class='caption text-center'><?= $person->forName.$person->firstName ?></div>
							 </div>
				  </div>	
		<?php endforeach;?>

	
	</div> 
</div>


<div class="col-md-8 col-sm-8 col-xs-8"> 
<!--
	 <div class="row text-center">
		  <button id="remain-work-btn" class="graph-btn btn btn-default" data-id="0">งานคงค้าง</button>
		  <button id="all-work-btn" class="graph-btn btn btn-default" data-id="0">งานทั้งหมด</button>
	  </div>
-->	  
<div class="row text-center">
	<h3><span id="chart-label">หน่วยงาน</span></h3>
</div>



<div class="row">
	<div class="col-md-11">
		<!-- data-ui=0 for factory chart-->
		<div id="main-chart" data-uid="0" style="min-height:300px" ></div>
	</div>
	<div class="col-md-11">
		<div id="sub-chart" style="min-height:300px" ></div>
	</div>

</div>

</div>







