<!DOCTYPE html>
<html>
	<head>
		<title>PHP Hello World</title>
	</head>
	<body>
		<?php
			date_default_timezone_set("America/New_York");
			$d = Date("D");
			if($d == "Sat" || $d == "Sun")
				echo "Have a good weekend!";
			else
				echo "Have a good weekday";
		?>
	</body>
</html>