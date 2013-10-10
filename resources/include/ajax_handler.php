<?php
// This is used for redirection of different Ajax-requests.
if(isset($_POST['action'])){
	include_once 'functions.php';	// functions must be included again.
	include_once '../config.php';	// sql-config must be included again
	sec_session_start();			// session variable must be resynced and a new session-id be generated.
	switch($_POST['action']) {
      	case 'create_user': 
           create_user(); 
           break;
        case 'login_user':
            login_user();
            break;
		case 'increase_product':
			sb_increase_product();
			break;
		case 'remove_product':
			sb_remove_product();
			break;
		case 'empty_cart':
			sb_empty_cart();
			break;
		case 'sb_update':
			sb_update();
			break;
		case 'logout_user':
			logout_user();
			break;
        default:
            break;
    }
}

// Creates a new user and saves all of the required information to the members table.
// Return	known message to the javascript.
function create_user(){
	if(isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_address'])){ // Checks if all of the required information is attached in the ajax-request
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE); // Then create a new mysqli-object used for connection against the database.
		$options = array('salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)); // Generates a new salt that will be stored in the members table along with the hashed password etc.
		$password_hash = password_hash($_POST['user_password'], PASSWORD_BCRYPT, $options); // The entered password is encrypted by using Blowfish-algorithm together with the random salt generated in previous step.
		if(createuser($_POST['user_name'], $password_hash, $_POST['user_email'], $_POST['user_address'],$options['salt'], $mysqli)){ // Try to save inforamtion to the members table.
			login($_POST['user_name'] , $_POST['user_password'], $mysqli); // At the same time we can perform the login-procedure.
		}
	}
	echo "created_account_error";
	die();
}

// Sets up a new sql-connection and then tries to login the user by using the entered login-credentials.
// @return known message to the javascript.
function login_user() {
	if(isset($_POST['user_name']) && isset($_POST['user_password'])){
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
		login($_POST['user_name'] , $_POST['user_password'], $mysqli);
	}
	echo 'login_error';
	die();
}

// Will increase desired product quantity to the current session cart.
// @return known message to the javascript.
function sb_increase_product(){
	if (isset($_POST['product_id']) && productExists($_POST['product_id'])){
		$product_id = $_POST['product_id'];
		if( isset( $_SESSION['cart'][$product_id] ) ){
			$_SESSION['cart'][$product_id]++;
		}else{
			$_SESSION['cart'][$product_id] = 1;
		}
		echo "sb_updated";
		die();
	}
	echo "sb_update_error";
	die();
}

// Will decrease desired product quantity to the current session cart.
// @return known message to the javascript.
function sb_remove_product(){
	if (isset($_POST['product_id']) && productExists($_POST['product_id'])){
		$product_id = $_POST['product_id'];
		if( isset( $_SESSION['cart'][$product_id] ) ){
			if( $_SESSION['cart'][$product_id] == 1 ){
				unset( $_SESSION['cart'][$product_id] );
			}else{
				unset($_SESSION['cart'][$product_id]);
			}
			echo "sb_updated";
			die();
		}
	}
	echo "sb_update_error";
	die();
}

// Will empty the current session cart.
// return known message to the javascript.
function sb_empty_cart(){
	if($_SESSION['cart']){
		unset($_SESSION['cart']);
		echo "sb_updated";
		die();
	}
	echo "sb_update_error";
	die();
}

// Used if shopping cart should be updated by using an ajax-call instead of location.reload.
// Never used...
// @return html-code:	The entire shopping cart.
function sb_update(){
	ob_start();
	if(login_check()){
		require_once(INCLUDE_PATH . "/shopping_basket.php");
	}else{
		echo"<p>You are not logged in!</p>";
	}
	ob_end_flush();
	die();
}
