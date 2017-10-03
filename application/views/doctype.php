<?php $count = 0; ?>
<ol class="breadcrumb">
  <li><a href="<?=site_url()?>">Home</a></li>
  <li class="active">ประเภทเอกสาร</li>
</ol>

<table id="<?=$method."-table"?>" class="table table-bordered responsive no-wrap">
<thead>
<tr>
	<th>ลำดับที่</th>
	<th>งาน</th>
	<th>ชื่อ</th>
	<th>ความเร็วเอกสาร(วัน)</th>
</tr>
</thead>
<tbody>
<?php foreach($doctypes->result() as $doctype): ?>
<tr id="<?= $doctype->doctypeID ?>">
	<td><?= ++$count ?> </td>
	<td><?= $doctype->workName ?></td>
	<td><?= $doctype->doctypeName ?> </td>
	<td><?= $doctype->speedValue ?> </td>
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
        <h4 class="modal-title">แบบบันทึกประเภทเอกสาร</h4>
      </div>
      <div class="modal-body">

				<div class="form-group">
					<label for="workID">งาน</label>
					<select id="workID" class="form-control">
					<?php foreach($works->result() as $work): ?>
					<option value="<?= $work->workID ?>"><?= $work->workName ?></option>
					<?php endforeach; ?>
					</select>
				</div>


				<div class="form-group">
					<label for="doctypeName">ชื่อเอกสาร</label>
					<input id="doctypeName" type="text" class="form-control" ></input>
				</div>

				

				<div class="form-group">
					<label for="speedValue">ความเร็ว(วัน)</label>
					<input id="speedValue" type="text" class="form-control" ></input>
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
