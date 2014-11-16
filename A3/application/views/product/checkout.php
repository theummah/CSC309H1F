<h2>Checkout</h2>
		<table class='product_table'>
		<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>


<?php
	
		echo "<div class='credit_card_form'>";
			echo form_open('store/logOrder');
				echo form_input('creditcard_number', '', 'placeholder="Credit Card Number"');	
				echo form_input('creditcard_month', '', 'type="number" min="1" placeholder="Credit Card Month"');
				echo form_input('creditcard_year', '', 'type="number" min="1999" placeholder="Credit Card Year"');



		foreach ($products as $product) {
			if (in_cart($product->id)){
				echo "<tr product-id=".$product->id.">";
				echo "<td>" . $product->name . "</td>";
				echo "<td>" . $product->description . "</td>";
				echo "<td>" . $product->price . "</td>";
				echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
				echo "<td class='delete_from_cart'><a>Delete</a></td>";		
				echo "<td><input min='1' class='change_quantity' value='".get_quantity_from_cart($product->id)."' /></td>";																				
			}
			echo "</tr>";
		}
		echo "<table>";
?>

	<input id="checkout" type="submit" value="Checkout"/>
	</form>
