<?php
	$count = 0;
?>
<ol class="breadcrumb">
  <li><a href="<?=site_url()?>">Home</a></li>
  <li class="active">รูปแบบสั่งการ</li>
</ol>

<table id="<?=$method."-table"?>" class="table table-bordered responsive no-wrap">
<thead>
<tr>
	<th>ลำดับที่</th>
	<th>ชื่อ</th>
</tr>
</thead>
<tbody>
<?php foreach($actions->result() as $action): ?>
<tr id="<?= $action->actionID ?>">
	<td><?= ++$count ?> </td>
	<td><?= $action->name ?> </td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<!---------------------------------------/body ------------------------------------------->


<!------------------------------------------modal ------------------------------------------->
<div id="<?= "add-".$method ?>" class="modal fade" data-edit-mode="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">แบบบันทึกรูปแบบดำเนินการ</h4>
      </div>
      <div class="modal-body">

				<div class="form-group">
					<label for="action-name">รายการ</label>
					<input id="action-name" type="text" class="form-control" ></input>
				</div>
      </div>
      <div class="modal-footer">
        <button id='save-btn' type="button" class="btn btn-primary">บันทึก</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!------------------------------------------/modal------------------------------------------->
