/**
 * @author Jonathan Klingberg
 */
jQuery(document).ready(function() {
	console.log( "ready!" );
	$("#btn-submit-login").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
		    // var data = array{
		    	// action : action_requested
	    		// username : 'user1',
	    		// password : 'user2'
	    	// }
	    ajax_route('check_login'); 
	}); 
	$("#btn-create-user").click(function(e){ 
	    e.preventDefault(); // prevents submit event if button is a submit
	    ajax_route('create_user'); 
	});
});

function ajax_route(action_requested, data){ 
    $.post("/resources/include/ajax_handler.php", {
    	action : action_requested
	},function(data){
        if (data.length>0){ 
            alert("Following ajax-action completed: "+action_requested + "result : " + data); 
        }else{
        	alert("Error in following ajax-action completed: "+action_requested); 
        }
   });
}