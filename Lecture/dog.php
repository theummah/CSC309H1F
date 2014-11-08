<?php
	//lecture on Ocotober 28, 2014
	class Dog {
		protected $name;
		protected $color;

		public function __construct($name, $color) {
			$this->name = $name;
			$this->color = $color
		}

		public function printInfo() {
			echo "Name: $this->name" + "<br />"
			+ "Color: $this->color" + "<br />"

		}
	}
?>