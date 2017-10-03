<?php
	$count = 0;
?>
<ol class="breadcrumb">
  <li><a href="<?=site_url()?>">Home</a></li>
  <li class="active">ข้อมูลบุคคล</li>
</ol>


<table id="<?=$method."-table"?>" class="table table-bordered responsive no-wrap">
<thead>
<tr>
	<th>ลำดับที่</th>
	<th>คำนำหน้า</th>
	<th>ชื่อ</th>
	<th>สกุล</th>
	<th>อีเมล์</th>
	<th>โทรศัพท์</th>
</tr>
</thead>
<tbody>
<?php foreach($persons->result() as $person): ?>
<tr id="<?= $person->personID ?>">
	<td><?= ++$count ?> </td>
	<td><?= $person->forName ?> </td>
	<td><?= $person->firstName ?> </td>
	<td><?= $person->lastName ?> </td>
	<td><?= $person->email ?> </td>
	<td><?= $person->phone ?> </td>
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
			<form>
				<div class="form-group">
					<label for="forName">คำนำหน้า</label>
					<input id="forName" type="text" class="form-control" ></input>
				</div>

				<div class="form-group">
					<label for="firstName">ชื่อ</label>
					<input id="firstName" type="text" class="form-control" ></input>
				</div>
				<div class="form-group">
					<label for="lastName">สกุล</label>
					<input id="lastName" type="text" class="form-control" ></input>
				</div>
				<div class="form-group">
					<label for="email">อีเมล์</label>
					<input id="email" type="text" class="form-control" ></input>
				</div>
				<div class="form-group">
					<label for="phone">โทรศัพท์</label>
					<input id="phone" type="text" class="form-control" ></input>
				</div>
			</form>
      </div>
      <div class="modal-footer">
        <button id='save-btn' type="button" class="btn btn-primary">บันทึก</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!------------------------------------------/modal------------------------------------------->
