/**
 * @author Jonathan Klingberg
 */
jQuery(document).ready(function() {
	console.log( "ready!" );
	$("#btn-submit-login").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		reset_field_classes();
		var ready = true;
		$('.lu-input-field').each(function (index){
			if($( this ).val().length <= 0){
				$( this ).addClass('invalid-field');
				$( this ).append('Please enter some data');
				ready = false;
			}
		});
		var action_data = {
			action : "login_user",
    		user_name : $('#username').val() ,
    		user_password : $('#password').val(),
    	};
    	if(ready){
	    	ajax_route(action_data);    		
    	}; 
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
	$("#btn-logout").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		var action_data = {
			action : "logout_user",
    	};
    	ajax_route(action_data);
	});
	$(".btn-add-to-cart").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
	    console.log($( this ).attr("id"));
		var action_data = {
			action : "increase_product",
    		product_id : $( this ).data("prod-id") 
    	};
    	ajax_route(action_data);
	});
	$(".btn-rm-from-cart").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
	    console.log($( this ).attr("id"));
		var action_data = {
			action : "remove_product",
    		product_id : $( this ).data("prod-id")
    	};
    	ajax_route(action_data);
	});
	$("#btn-empty-cart").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		var action_data = {
			action : "empty_cart",
    	};
    	ajax_route(action_data);
	});
	$("#btn-checkout-cart").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		document.location = "?page=checkout";
	});
	$(".btn-return-to-products").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		document.location = "?page=products";
	});
	$("#btn-checkout-final").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		document.location = "?page=create_payment";
	});
	$("#btn-finish-payment").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		document.location = "?page=payment_success";
	});
	
	
	
});

function reset_field_classes(){
	$('.cu-input-field').each(function (index){
		$( this ).removeClass('invalid-field');
	});
}
function sb_update(){
	document.location.reload();
	// var action_data = {
		// action : "sb_update",
	// };
    // $.ajax({
		// type: "POST",
		// url: "/resources/include/ajax_handler.php",
		// data: action_data,
		// dataType: "html",
	// }) 
	// .success(function( data ){
		// document.location.reload();
		// // $('#right-panel').html(data);
		// console.log( "Ajax error-response:", data );
	// })
	// .error(function(jqXHR, textStatus){
		// console.log( "Ajax error-response:", textStatus );
	// });
}

function account_locked(){
	alert("Account is locked for 3 minutes!");
}

function account_logged_in(){
	document.location = "?page=products";
}

function wrong_password(){
	alert("Wrong password!");
}

function wrong_username(){
	alert("Wrong username!");
}

function created_account(){
	alert("Created account!");
	document.location = "?page=login_success";
}

function created_account_error(){
	alert("Could not create new user account, wait a minute and then try again!");
}

function login_error(){
	alert("Could not login, wait a minute and then try again!");
}

function user_logged_out(){
	document.location = "?page=home";
}

// function user_logged_in(){
	// alert("User_logged_in!");
// }
// 
// function user_not_logged_in(){
	// alert("User_not_logged_in!");
// }

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
		switch(data){
			case "sb_updated":
				sb_update();
				break;
			case "account_locked":
			  	account_locked();
			  	break;
  			case "login_success":
			  	account_logged_in();
			  	break;
  			case "wrong_password":
			  	wrong_password();
			  	break;
			case "wrong_username":
			  	wrong_username();
			  	break;
  			case "created_account":
			  	created_account();
			  	break;
  			case "created_account_error":
			  	created_account_error();
			  	break;
  			case "login_error":
			  	login_error();
			  	break;
			case "user_logged_out":
			  	user_logged_out();
			  	break;
			  	
			// case "user_logged_in":
			  	// user_logged_in();
			  	// break;	
			// case "user_not_logged_in":
			  	// user_not_logged_in();
			  	// break;	
			default:
		}
	})
	.error(function(jqXHR, textStatus){
		console.log( "Ajax error-response:", textStatus );
	});
}