<?php
	include_once 'dog.php';
	include_once 'smartdog.php';

	session_start();
	header("Cache-Control: no-cache, must-revalidate");
?>

<!DOCTYPE html>
<html>
	<body>
		<h1>List Dogs</h1>
		<?php
			if(isset($_SESSION["dogs"])) {
				$dogs = $_SESSION["dogs"];
				foreach($dogs as $dog) {
		?>
					<p>
					<?= $dog->printInfo(); ?> <!-- php shorthand-->
					</p>
		<?php
				}
			}
		?>
	</body>
</html>