<?php
	include_once 'dog.php';

	class Smartdog extends Dog {
		protected $trick;

		public function __construct($name, $color, $trick) {
			parent::__construct($name, $color)
			$this->trick = $trick;
		}

		public function printInfo() {
			parent::printInfo();
			echo "Trick: $this->trick <br />"
		}
	}
?>