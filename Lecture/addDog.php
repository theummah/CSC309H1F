<!DOCTYPE html>

<html>

	<head>
		<style>
			input {
				display: block;
			}
		</style>
	</head>

	<body>
		<h1>New Dog</h1>
		<form action="">
			Name <input type="text" name="name" />
			Color <input type="text" name="color" />
			<input type="submit">
		</form>
	</body>

</html>

<?php
	include_once 'dog.php';

	session_start();

	header("Cache-Control: no cache, must revalidate");

	if(isset($_REQUEST["name"])) {
		$name = $_REQUEST["name"];
		$color = $_REQUEST["color"];
		$dog = new Dog($name, $color);

		if(isset($_SESSION["dogs"]))
			$_SESSION["dogs"] = array();

		$_SESSION["dogs"][] = $dog; //append item to end of array

		header("location: index.php");

		return;
	}
?>
