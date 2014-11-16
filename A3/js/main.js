$(document).on('mouseenter', '.user_nav', function(){
	$("#nav_list").animate({height:'100%'},300);
});

$(document).on('mouseleave','.user_nav', function(){
	//alert('left user nav');
	//alert($("#nav_list:hover").length);

	if ($("#nav_list:hover").length){
		return false;
	}
	else{
		$("#nav_list").animate({height:'0%'},300);
	}
});

$(document).on('mouseleave','#nav_list ul', function(){
	if ($("#nav_list:hover").length){
		return false;
	}
	else{
		$("#nav_list").animate({height:'0%'},300);
	}
});


$(document).on('click', '.add_to_cart', function(){
	var $this = $(this);
	var product_id = $(this).parent().attr('product-id');
	$.get("http://localhost:8888/quickStore/store/add_to_cart", 
		{add: product_id, quantity: 1}, 
		function(data){
			data = $.parseJSON(data);
			console.log(data);

			$this.find('a').html("Remove From Cart");
			$this.removeClass('add_to_cart');
			$this.addClass('remove_from_cart');	
					
			// if (data.status == "GOOD"){				
			// 	// Added to cart, thus swap out this anchor and its route				

			// 	return false;
			// }
			// else{
			// 	return false;
			// }
		}
	);
});

$(document).on('click', '.remove_from_cart', function(){
	var $this = $(this);	
	var product_id = $(this).parent().attr('product-id');
	$.post("http://localhost:8888/quickStore/store/remove_from_cart",{remove: product_id}, 
		function(data){

			data = $.parseJSON(data);

			$this.find('a').html("Add to Cart");
			$this.removeClass('remove_from_cart');
			$this.addClass('add_to_cart');	
			
			// if (data.status == "GOOD"){
			// 	console.log('removed');
			// 	return false;
			// }
			// else{
			// 	console.log("WATERMELON");
			// 	return false;
			// }
		}
	);
});


// function to change quantity in cart 
$(document).on('change', '.change_quantity', function(){
	var product_id = $(this).parent().parent().attr('product-id');
	console.log(product_id);
	var quan = $(this).val();
	$.post("http://localhost:8888/quickStore/store/change_quantity",{pid: product_id, quantity: quan}, 
		function(data){

			data = $.parseJSON(data);
			console.log(data);
			// $this.find('a').html("Add to Cart");
			// $this.removeClass('remove_from_cart');
			// $this.addClass('add_to_cart');	
			
			// if (data.status == "GOOD"){
			// 	console.log('removed');
			// 	return false;
			// }
			// else{
			// 	console.log("WATERMELON");
			// 	return false;
			// }
		}
	);

});