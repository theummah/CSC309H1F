<h2>Checkout</h2>
<p class="required">* Required</p>
		<table class='product_table'>
		<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>


<?php
	
		echo "<div class='credit_card_form'>";
			echo '<form onsubmit="return isValid()" action="//localhost/estore/store/logOrder" method="get">';
				echo form_input('creditcard_number', '', 'type="text" placeholder="Credit Card Number"');
				echo '<span class="error">* Credit card number must be 16 digits</span>';
				echo form_input('creditcard_expiry', '', 'type="text" placeholder="Credit Card Expiry MM/YY"');
				echo '<span class="error">* expiry date must be valid and in the form MM/YY</span>';

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
?>
		
			<input id="checkout" type="submit" value="Checkout"/>
			</form>
		</table>
	</div>
