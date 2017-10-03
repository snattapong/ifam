<ol class="breadcrumb">
  <li><a href="<?=site_url()?>">Home</a></li>
  <!-- <li><a href="<?=site_url('report')?>">รายงาน</a></li>-->
  <li class="active">เรื่องร้องเรียน</li>
</ol>

<div class="row">
	
</div>

<table id="<?=$method."-table"?>" class="table table-bordered responsive no-wrap"></table>

<!---------------------------------------/body ------------------------------------------->

<!------------------------------------------modal ------------------------------------------->
<div id="date-filter" class="modal fade" data-edit-mode="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ระบุวันที่ร้องเรียน</h4>
      </div>
      <div class="modal-body">

				<div class="form-group">
					<label for="fromDate">จากวันที่</label>
					<input id="fromDate" type="text" class="form-control" data-provide="datepicker" data-date-language="th-th"></input>
				</div>
				<div class="form-group">
					<label for="toDate">ถึงวันที่</label>
					<input id="toDate" type="text" class="form-control" data-provide="datepicker" data-date-language="th-th"></input>
				</div>

      </div>
      <div class="modal-footer">
        <button id='filter-btn' type="button" class="btn btn-primary">ตกลง</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!------------------------------------------/modal------------------------------------------->
