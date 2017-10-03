
<!------------------------------------------alarm modal ------------------------------------------->
<div id="alarm-modal" class="modal fade" data-has-alarm="<?= $hasAlarm ? "true" : "false" ?>" tabindex="-2" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ภาระงานปัจจุบัน</h4>
      </div>
      <div class="modal-body">
				<div id="workload-front">
					<table class="table table-bordered table-striped ">
					<thead>
						<tr>
							<th>เจ้าของเรื่อง</th>
							<th>งานปัจจุบัน</th>
							<th>ใกล้ถึงกำหนด</th>
							<th>เลยกำหนด</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($workloads->result() as $work): ?>	
							<tr>
							  <td><a href="#" data-id="<?= $work->owner ?>" class="alarm-pop"><?= $work->name ?></a></td>
							  <td><?= $work->workload ?> </td>
							  <td><?= $work->remain ?> </td>
							  <td><?= $work->over == NULL ? 0 : $work->over ?> </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					</table>
				</div> <!-- /workload-table -->
				<div id="workload-back" style="display:none">
					<h2>Back</h2>
				</div>

      </div> <!-- /modal-body -->

      <div class="modal-footer">
		  <input type="checkbox" id='memAlarm' <?= $hasAlarm ? "" : "checked"  ?> /> <label for="memAlarm">ไม่ต้องแจ้งเตือนอีกในวันนี้</label>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div><!-- /modal-footer -->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!------------------------------------------/modal------------------------------------------->
