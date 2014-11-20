<h2>Confirm Order</h2>
	
	<table class='product_table'>
		<tr><th>ID</th><th>Name</th><th>Photo</th><th>Price</th><th>Quantity</th></tr>
		<?php
		$total_cost = 0;
		foreach ($products as $product) {
			if (in_cart($product->id)) {
				echo "<tr product-id=" . $product->id . ">";
				echo "<td>" . $product->id . "</td>";
				echo "<td>" . $product->name . "</td>";
				echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='50px' /></td>";
				echo "<td>" . $product->price . "</td>";
				echo "<td>" . get_quantity_from_cart($product->id) . "</td>";

				$total_cost += $product->price * get_quantity_from_cart($product->id);
			}
		}
		?>
		<hr />
		<tr><td><b>Total Cost</b></td><td></td><td></td><td></td><td><b><?php echo $total_cost; ?></b></td></tr>
	</table><!-- end of order_cost-->