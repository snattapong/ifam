<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible"> 
<meta content="width=device-width,initial-scale=1" name="viewport">
<title>
IFAM(Intelligence Factory Aid Management System)
</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- <link href="<?=base_url('assets/bootstrap.min.css')?>" rel="stylesheet"> -->


<!-- page css-->
<?php
	//load view if exists
	if(isset($method)){
		$css = "styles/".$class."_".$method."_css";
		if (is_file(APPPATH."views/$css.php" ))
		{
			 $this->load->view($css);
		}
	}
?>


<link href="<?= base_url("assets/css/main.css") ?>" rel="stylesheet">
</head>

<body>

<?php if($method != "login" ): ?>

<nav class="navbar navbar-default">
<div class="container-fulid">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<a class="navbar-brand" href="<?= site_url() ?>">IFAM</a>	
	</div><!-- /navbar-header-->
	

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">เมนูหลัก <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li> <a href="<?=site_url('main/document')?>">แฟ้มเอกสาร</a></li>
					<li> <a href="<?=site_url('main/work')?>">กลุ่มงาน</a></li>
					<li> <a href="<?=site_url('main/doctype')?>">ประเภทเอกสาร</a></li>
					<li> <a href="<?=site_url('main/action')?>">รูปแบบสั่งการ</a></li>
					<li> <a href="<?=site_url('main/person')?>">ข้อมูลบุคคล</a></li>
					<!-- <li> <a href="<?=site_url('main/speed')?>">ความเร็วเอกสาร</a></li>-->
					<!-- <li> <a href="<?=site_url('main/contact')?>">ข้อมูลผู้ติดต่อ</a></li> -->
				</ul><!--/ul dropdown-menu-->

			</li>
		</ul><!-- /ul-nav-->

		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">รายงาน<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li> <a href='<?= site_url('report/fac_req') ?>'>โรงงานที่ขออนุญาต</a></li>
					<li> <a href='<?= site_url('report/fac_exp') ?>'>โรงงานที่แจ้งเลิก</a></li>
					<li> <a href='<?= site_url('report/complaint') ?>'>เรื่องร้องเรียน</a></li>
				</ul><!--/ul dropdown-menu-->

			</li>
		</ul><!-- /ul-nav-->



		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><?= $this->session->userdata("firstName") ?><span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li> <a href='<?= site_url('main/logout') ?>'>Logout</a></li>
				</ul><!--/ul dropdown-menu-->

			</li>
		</ul><!-- /ul-nav-->


	</div><!-- /navbar-collapse-->
</div><!-- /navbar container-fluid-->
</nav>
<?php endif; ?>
<div id="main-container" class="container-fluid">


