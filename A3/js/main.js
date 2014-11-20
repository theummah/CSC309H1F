$(document).ready(function() {
	$(document).on('mouseenter', '.user_nav', function(){
	$("#nav_list").animate({height:'100%'},300);
	});

	$(document).on('mouseleave','#nav_list ul', function(){
		$("#nav_list").animate({height:'0%'},300);
	});
});


$(document).on('click', '.add_to_cart', function(){
	var $this = $(this);
	var product_id = $(this).parent().attr('product-id');
	$.get("//localhost/estore/store/add_to_cart", 
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
	$.post("//localhost/estore/store/remove_from_cart",{remove: product_id}, 
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
	$.post("//localhost/estore/store/change_quantity",{pid: product_id, quantity: quan}, 
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

function isValid() {
	var $this = $('#checkout');
	
	$this.parent().find('.error').hide();

	var valid = true;

	var ccNum = $this.parent().find('input[name=creditcard_number]').val()
	var ccExp = $this.parent().find('input[name=creditcard_expiry]').val()

	var ccNumPattern = /\d{16}/;
	var ccExpPattern = /((0[123456789])|(1[012]))\/((1[456789])|([23456789][0-9]))/;

	var today = new Date();

	//check that the credit card number is 16 digits first
	if(!ccNumPattern.test(ccNum)) {
		$this.parent().find('.error').first().fadeIn();
		valid = false;
	}
	//check if the expiry date is valid
	if(ccExpPattern.test(ccExp)) {

		if(ccExp[0] === '0')
			var ccMonth = parseInt(ccExp[1]);
		else
			var ccMonth = parseInt(ccExp[0] + ccExp[1]);

		var ccYear = parseInt(ccExp[3] + ccExp[4]);

		//if in year of expiry
		if(ccYear === (today.getYear() % 100))
			//check if month has passed
			if((today.getMonth() + 1) > ccMonth) {
				$this.parent().find('.error').last().fadeIn();
				valid = false;
			}
	}
	else {
		$this.parent().find('.error').last().fadeIn();
		valid = false;
	}

	return valid;//should be false if all tests are passed
}