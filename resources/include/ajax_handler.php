<?php
if(isset($_POST['action'])){
	include_once 'functions.php';
	include_once '../config.php';
	sec_session_start();
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

function create_user(){
	if(isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_address'])){
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE); //Om all in data är satt, gör en anslutning mot databasen.
		$options = array('salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
		$password_hash = password_hash($_POST['user_password'], PASSWORD_BCRYPT, $options);
		if(createuser($_POST['user_name'], $password_hash, $_POST['user_email'], $_POST['user_address'],$options['salt'], $mysqli)){
			login($_POST['user_name'] , $_POST['user_password'], $mysqli);
		} //Skicka vidare variablerna för att lägga in i databasen.
	}
	echo "created_account_error";
	die();
}

function login_user() {
	if(isset($_POST['user_name']) && isset($_POST['user_password'])){
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
		login($_POST['user_name'] , $_POST['user_password'], $mysqli);
	}
	echo 'login_error';
	die();
}

function sb_increase_product(){
	if (isset($_POST['product_id']) && productExists($_POST['product_id'])){
		$product_id = $_POST['product_id'];
		// sec_session_start();
		if( isset( $_SESSION['cart'][$product_id] ) ){
			$_SESSION['cart'][$product_id]++;
		}else{
			$_SESSION['cart'][$product_id] = 1;
		}
		echo "sb_updated";
	}else{
		echo "No product added";
	}
	die();
}

function sb_remove_product(){
	if (isset($_POST['product_id']) && productExists($_POST['product_id'])){
		$product_id = $_POST['product_id'];
		// sec_session_start();
		// 
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

function sb_empty_cart(){
	if($_SESSION['cart']){
		unset($_SESSION['cart']);
		echo "sb_updated";
		die();
	}
	echo "sb_update_error";
	die();
}

function sb_update(){
	ob_start();
	if(login_check()){
		echo "<h2>Shopping Cart</h2>";
		require_once(INCLUDE_PATH . "/shopping_basket.php");
	}else{
		echo"<p>You are not logged in!</p>";
	}
	ob_end_flush();
	die();
	// ob_start();
	// include_once('shopping_basket.php');
	// ob_end_flush();
}


//  ___________ CREATE DB CONNECTION STARTS HERE __________  http://www.phpeasystep.com/phptu/6.html
//
//			_________ HERE IS HOW WE SHOULD DO THIS _________
//			http://webhelp.ucs.ed.ac.uk/services/mysql/hide-pass.php
//			http://stackoverflow.com/questions/11181675/mysql-php-is-this-a-secure-way-to-connect-to-mysql-db
//			http://stackoverflow.com/questions/97984/how-to-secure-database-passwords-in-php
//			http://www.openwall.com/articles/PHP-Users-Passwords
//			__________________________________________________
//
// ob_start();
// 
// // Define $myusername and $mypassword 
// $myusername=$_POST['myusername']; 
// $mypassword=$_POST['mypassword']; 
// 
// // To protect MySQL injection (more detail about MySQL injection)
// $myusername = stripslashes($myusername);
// $mypassword = stripslashes($mypassword);
// $myusername = mysql_real_escape_string($myusername);
// $mypassword = mysql_real_escape_string($mypassword);
// $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
// $result=mysql_query($sql);
// 
// // Mysql_num_row is counting table row
// $count=mysql_num_rows($result);
// 
// // If result matched $myusername and $mypassword, table row must be 1 row
// if($count==1){
// 
// // Register $myusername, $mypassword and redirect to file "login_success.php"
// global $_SESSION;
// if (!isset($_SESSION['ServGen'])) {
// session_destroy();
// }
// session_regenerate_id();
// $_SESSION['ServGen'] = TRUE;
// // header('Location: http://www.example.com/');
// require_once('login_success.php');
// // header("location:login_success.php");
// }
// else {
// echo "Wrong Username or Password";
// }
// ob_end_flush();

//  ___________ CREATE DB CONNECTION ENDS HERE __________

//  ___________ CREATE USER STARTS HERE __________

// if(isset($_GET['action'])=='add_user') {
    // add_user($_POST['new_username'], $_POST['new_password']);
// }else{
// 	
// }
// function add_user($username, $password){
// 	
	// // To protect MySQL injection (more detail about MySQL injection)
	// $username = validate_user_input($username);
	// $password = validate_user_input($password);
// 
	// $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
	// var_dump("salt:" . $salt);
	// if(CRYPT_BLOWFISH == 1){
		// $password_hash = crypt($username . $password , $salt);
		// var_dump("pass:" . $password_hash);
		// if (strlen($password_hash) < 13 || $password_hash == $salt){
			// die('Invalid hash');
		// }else{
			// $sql="INSERT INTO $tbl_name VALUE( username='$myusername' and password='$mypassword'";
			// $result=mysql_query($sql);
// 			
			// // Mysql_num_row is counting table row
			// $count=mysql_num_rows($result);
// 			
			// // If result matched $myusername and $mypassword, table row must be 1 row
			// if($count==1){	
		// }
	// }
	// // $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
	// // $result=mysql_query($sql);
	// // if(not already exixts in db){
		// // hash($pw);
		// // return add to db
	// // }elese{
		// // return	user already exists;
	// // }
// }
// function validate_user_input($string, $type='default'){
	// $string = stripslashes($string);
	// $string = strip_tags($string);
	// if($type == 'username'){
		// // REGEXP
	// }elseif($type == 'password'){
		// // REGEXP
	// }elseif($type == 'email'){
		// // REGEXP
	// }elseif($type == 'default'){
		// // REGEXP
	// }
	// return $string;
// }

//  ___________ CREATE USER ENDS HERE __________
?>
