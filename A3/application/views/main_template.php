<html>
	<head>
		<title>Tha Spot</title>
	</head>
		<?php

			$_js = $this->config->item('js');
			$_css = $this->config->item('css');

			foreach ($_css as $key => $value){
				echo link_tag("css/$value");
			}

			foreach ($_js as $key => $value){
				echo "<script type='text/javascript' src='".base_url()."js/$value'></script>";
			}			

		?>
	<body>

		<?php
			$this->load->view('header.php');
		?>

		<?php
			$this->load->view('content.php')
		?>

		
	</body>
</html>