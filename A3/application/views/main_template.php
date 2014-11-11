<html>
	<head>
	</head>
		<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300' rel='stylesheet' type='text/css'>		
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
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

		<img class="container_cover" style="background:url(<?php echo base_url();?>/images/88H.jpg);" />

		<div class="container">
			<?php
				if (isset($content)){
					echo $content;
				}				
				else{
					echo "No content!";
				}
			?>
		</div>

		
	</body>
</html>