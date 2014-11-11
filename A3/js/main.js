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
