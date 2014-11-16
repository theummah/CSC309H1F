<h2>Shop / Products List Page</h2>
<?php 
		
		// Uses admin flag to make Add New, Delete and Edit products only accessible to 
		// the admin
		if ($is_admin)
		{
			echo "<p>" . anchor('store/newForm','Add New') . "</p>";
		}
 	  
		echo "<table class='product_table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {

			echo "<tr product-id=".$product->id.">";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";

			if ($is_admin){
				echo "<td>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
				echo "<td>" . anchor("store/editForm/$product->id",'Edit') . "</td>";
			}
			echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";

			if (in_cart($product->id)){
				echo "<td class='remove_from_cart'><a>Remove From Cart</a></td>";											
			}
			else{
				echo "<td class='add_to_cart'><a>Add To Cart</a></td>";	


			}				
			
			

			echo "</tr>";

		}
		echo "<table>";
?>	

