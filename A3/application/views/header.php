
<div id="header_container">
<span id="header_text">
quickStore
</span>

<?php if(isset($username)) : ?>
	<div class="user_nav">
		<div class="user_nav_icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
			<g id="Down">
				<circle fill="none" stroke="#000000" stroke-width="6" stroke-miterlimit="10" cx="50" cy="49.998" r="47"/>
				<polygon points="53,21 53,67.998 67,53.998 67,61.998 50,78.998 33,61.998 33,53.998 47,67.998 47,21  "/>
			</g>
			</svg>
		</div>
		<div id="username"><?=$username?></div>
	</div>
<?php endif; ?>


</div>

<?php if(isset($username)) : ?>
	<div id="nav_list">
		<ul>
			<li>
				<a>Home</a>
			</li>
			<li>
				<a>Store</a>
			</li>
			<li>
				<a>View Cart</a>
			</li>
			<li>
				<a>Checkout</a>
			</li>		
			<li>
				<a href="<?php echo base_url()?>logout">Log Out</a>
			</li>		
		</ul>
	</div>
<?php endif; ?>
