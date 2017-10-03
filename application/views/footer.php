<div class="footer text-center">
</div>

</div><!-- end #main-container -->

<!-- default script-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- page script-->
<?php
	//load view if exists
	if(isset($class)){
			$script = "scripts/$class"."_"."$method"."_js";
			if (is_file(APPPATH."views/$script.php" ))
			{
				 $data["method"] = $method;
				 $this->load->view($script,$method);
			}
	}
?>

</body>
</html>
