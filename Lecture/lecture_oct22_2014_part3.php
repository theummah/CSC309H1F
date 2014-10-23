<!DOCTYPE html>
<html>
	<head>
		<title>PHP Hello World</title>
		<?php
		function fact($val) {
			if($val <= 1)
				return $val;
			return $val * fact($val - 1);
		}
		?>
	</head>
	<body>
		<form action="factorial.php">
			Factorial for <input type="text" name="factNum" />
			<input type="submit" />
		</form>
		<?php
		$num = $_GET["factNum"];
		if(is_numeric($num) && $num > 0)
			echo fact($num);
		?>
	</body>
</html>