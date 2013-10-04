<?php
include 'db_connect.php';
include 'functions.php';
sec_session_start();

// make sure u have an action to take
if(isset($_POST['action'])){
	switch($_POST['action']) {
      	case 'create_user': 
           create_user(); 
           break;
        case 'check_login':
            check_login();
            break;
        default:
            break;
    }
}
function create_user(){
	
	if(isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_address'])){
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE); //Om all in data är satt, gör en anslutning mot databasen.
		
		$salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM); //Skapa ett random salt.
	var_dump("salt:" . $salt);
	if(CRYPT_BLOWFISH == 1){
		$password_hash = crypt($_POST['user_name']. $_POST['user_password'] , $salt); //Skapa ett hashat pw med blowfish cryptering.
		var_dump("pass:" . $password_hash);
		if (strlen($password_hash) < 13 || $password_hash == $salt){ 	//kontrolera så hashen är ok.
			die('Invalid hash');
		}else{
						
					createuser($_POST['user_name'], $password_hash, $_POST['user_email'], $_POST['user_address'],$salt, $mysqli); //Skicka vidare variablerna för att lägag in i databasen.
				   
				
				
			
		}
	}
		
		echo "Created user!";
	}else{
		echo "Require more info!";
	}
	die();
}

function login_user() {
	
	if(isset($_POST['user_name']) && isset($_POST['user_password'])){
		
		
	}
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	
	login('test@exempel.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', $mysqli);
	
	echo "User logged in successfully!";	
	die();
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
