<!DOCTYPE html>
<html>
	<head>
		<title>PHP Hello World</title>
	</head>
	<body>
		<?php
		for($i = 1; i <= 3; $i++) {
		?>
			<h<?=$i?>>This a level <?=$i?> heading.</h<?=$i?>>
			more text!!!
		<?php
		}
		?>
	</body>
</html>