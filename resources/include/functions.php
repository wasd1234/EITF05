<?php
// Configures and sets up a session new session and closing the old one.
function sec_session_start() {
        $session_name = 'webshop_session'; // Set a custom session name
        $secure = true; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.  
 }

// Check login-credentials against stored info in db.
function login($username , $password, $mysqli) {
	// Search for a matching username in db and collects needed information.
	if ($stmt = $mysqli->prepare("SELECT username, password_hash, salt FROM members WHERE username = ?")) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username, $db_password, $salt);
		$stmt->fetch();
		if($stmt->num_rows == 1) { // Checks that entered username actually exists in members db.
			$options = array('salt' => $salt); // default cold = 10 is OK
			$password = password_hash($password, PASSWORD_BCRYPT, $options); // Hashes password by using the salt stored in db.
			if (checkbrute($username, $mysqli) == true) {// Checks that the user isn't locked out.
				echo "account_locked";// The account is locked
				die();
			} else {
				if ($db_password == $password) {
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);// XSS protection as we might print this value
					$_SESSION['username'] = $username;
					$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
					echo "login_success";
					header("Location: http://www.example.com/");
					die();
				} else {// Wrong password, save as unsuccessful-attempt to db.
					$now = time();
					$mysqli -> query("INSERT INTO login_attempts (username, time) VALUES ('$username', '$now')");
					echo 'wrong_password';
					die();
				}
			}
		}else{
			echo 'wrong_username';
	        die();
		}
	}
}


function checkbrute($username, $mysqli) {
	$now = time();
	$valid_attempts = $now - (3 * 60); // Alla login försök från de senaste 3 min räknas in.
	if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE username = ? AND time > '$valid_attempts'")) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows <= 5) {
			return false;
		}
	}
	return true; //vid fler än fem inloggninsförsök retuneras false
}

function login_check() {
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if (isset($_SESSION['username'])) { // Check if username session variable is set
		$username = $_SESSION['username'];
		$login_string = $_SESSION['login_string'];
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		if ($stmt = $mysqli->prepare("SELECT password_hash FROM members WHERE username = ? LIMIT 1")) { 
			$stmt->bind_param('s', $username); // Bind "$user_id" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			if($stmt->num_rows == 1) { // If the user exists
				$stmt->bind_result($password); // get variables from result.
				$stmt->fetch();
				$login_check = hash('sha512', $password.$user_browser);
				if($login_check == $login_string) {
					return true; 
					// echo "user_logged_in"; // still the same browser!
					// die();
				} 
				// echo" Another browser is used! Something is strange!";
			}  
			// echo" Could not find username in db...";
		}  
		// echo "sql syntax error";
	}
	return false;
	// echo"user_not_logged_in";// No one is yet logged in!
	// die();
}

function createuser($username, $passwordHash, $useremail, $useraddress, $salt, $mysqli) {
	if ($stmt = $mysqli->prepare("INSERT INTO members (username, password_hash, salt, address, useremail) VALUES (?, ?, ?, ?, ?)")) {
		$stmt ->bind_param('sssss', $username, $passwordHash, $salt, $useraddress, $useremail ); 
		if($stmt->execute()){// Execute the prepared query.
			return true;
		} 		
	}
	return false;
}

function logout_user(){
	// sec_session_start(); 
	$_SESSION = array(); // Unset all session values
	$params = session_get_cookie_params(); // get session parameters 
	// Delete the actual cookie.
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	session_destroy();
	echo "user_logged_out";
	die();
}

//function to check if a product exists
function productExists($product_id) {
    //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
    return true;
    // $sql = sprintf("SELECT * FROM php_shop_products WHERE id = %d;", $product_id); 
//     
    // return mysql_num_rows(mysql_query($sql)) > 0;
}
?>
