<div id="header_container">
	<span id="header_text">
		quickStore
	</span>

	<button class="button">&#9776;</button>
	<nav class="menu" role='navigation'>
	  <ul>
	    <li><a href="#">Home</a></li>
	    <li><a href="#">About</a></li>
	    <li><a href="#">Clients</a></li>
	    <li><a href="#">Contact Us</a></li>
	  </ul> 
	</nav>

	<?php
		if (isset($username)){
			echo "Username: ".$username;
		}
	?>
</div>