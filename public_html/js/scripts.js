/**
 * @author Jonathan Klingberg
 */
jQuery(document).ready(function() {
	console.log( "ready!" );
	$("#btn-submit-login").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		    var userinput = {
		    	action : action_requested,
	    		username : 'user1',
	    		password : 'user2'
	    	};
	    ajax_route(action_requested, userinput); 
	}); 
	$("#btn-create-user").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
	    console.log( "name: " + $('#new_username').val() + " pass: " + $('#new_password').val() + " mail: " + $('#new_email').val() );
		// if(validate_username($('#new_username').val())){
			// $('#new_username').addClass('valid-username');
		// }else{
			// $('#new_username').addClass('invalid-username');
		// }
		reset_field_classes();
		var ready = true;
		$('.cu-input-field').each(function (index){
			if($( this ).val().length > 0){
				console.log("long: " + index);
			}else{
				$( this ).addClass('invalid-field');
				$( this ).append('<p> Please enter some data </p>');
				console.log("short: "+ index);
				ready = false;
			}
		});
		var action_data = {
			action : "create_user",
    		user_name : $('#new_username').val() ,
    		user_password : $('#new_password').val(),
    		user_email : $('#new_email').val(),
    		user_address : $('#new_address').val()
    	};
    	if(ready){
	    	ajax_route(action_data);    		
    	}
	});
});

function reset_field_classes(){
	$('.cu-input-field').each(function (index){
		$( this ).removeClass('invalid-field');
	});
}
// 
// function validate_username(username){
	// return true;
// }

function ajax_route(action_data){ 
	var data = action_data;
    $.ajax({
		type: "POST",
		url: "/resources/include/ajax_handler.php",
		data: data,
	}) 
	.success(function( data ) {
		console.log( "Ajax success-response:", data );
	})
	.error(function(jqXHR, textStatus){
		console.log( "Ajax error-response:", textStatus );
	});
}