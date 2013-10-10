<?php
// Configures and sets up a new session and closing the old one.
function sec_session_start() {
        $session_name = 'webshop_session'; // Sets a custom session name
        $secure = true; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies and never show any information in the URL.
        $cookieParams = session_get_cookie_params(); // Gets current cookies parameters.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); // Create at session cookie.
        session_name($session_name); // Sets a custom name of session.
        if (session_status() == PHP_SESSION_NONE) {
		    session_start(); // Start the session.
		} 
        session_regenerate_id(); // regenerated the session and delete the old one for security purposes.
 }

// Uses entered information and creates a new user that is saved to the members table.
function createuser($username, $passwordHash, $useremail, $useraddress, $salt, $mysqli) {
	if ($stmt = $mysqli->prepare("INSERT INTO members (username, password_hash, salt, address, useremail) VALUES (?, ?, ?, ?, ?)")) {
		$stmt ->bind_param('sssss', $username, $passwordHash, $salt, $useraddress, $useremail ); 
		if($stmt->execute()){// Execute the prepared statement query.
			return true;
		} 		
	}
	return false;
}

// Check login-credentials against stored info in db to find any matching username and password pairs.
// @return known message to the client javascript.
function login($username , $password, $mysqli) {
	// Search for a matching username in db and collects its belonging information.
	if ($stmt = $mysqli->prepare("SELECT username, password_hash, salt FROM members WHERE username = ?")) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username, $db_password, $salt);
		$stmt->fetch();
		if($stmt->num_rows == 1) { // Checks that entered username actually exists in members table.
			$options = array('salt' => $salt); // default cost = 10, that's OK!
			$password = password_hash($password, PASSWORD_BCRYPT, $options); // Hashes password by using the salt created when the user first time was created.
			if (checkbrute($username, $mysqli) == true) {// Checks that the user isn't locked out.
				echo "account_locked";// The account is currently locked
				die();
			} else {
				if ($db_password == $password) { // Checks that entered password matches the one in the database.
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Gets the type of clients browser .
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);// Replaces unwanted characters because we'll display the username on the screen. Otherwise vulnarebale againt XSS-attack.
					$_SESSION['username'] = $username; // Saves the username of currently logged in user.
					$_SESSION['login_string'] = hash('sha512', $password.$user_browser); // Stores a hash of password and clients browser-type as a kind of session-token. Otherwise vulnerable against replay and hi-jacking attacks.
					echo "login_success";
					die();
				} else {// Wrong password, save as unsuccessful-attempt to db.
					$now = time(); // gets current server time.
					$mysqli -> query("INSERT INTO login_attempts (username, time) VALUES ('$username', '$now')"); // saves current time of login-attempt along with the username in login_attempts-table.
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
// Checks the login_attempts-table for previous login-attempts of chosen username in the last 3 minutes. This will block the username for 3 minutes.
// @return	TRUE:	when username is blocked. 		More then 5 attempts in the last 3 minutes.
// @retnr 	FALSE:	when username not is blocked. 	Less then or equal to 5 attempts in the last 3 minutes.
function checkbrute($username, $mysqli) {
	$now = time();
	$valid_attempts = $now - (3 * 60); // All login-attempts from the last 3 minutes are counted as valid.
	if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE username = ? AND time > '$valid_attempts'")) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows <= 5) {
			return false;
		}
	}
	return true;
}

// Checks if a user is currently logged in and that the username actually exists in the members table.
// @return	TRUE:	when current session-username exists in members table and the same browser as when login still is used.
// @return	FALSE:	when current session-username doesn't exist in members table or if the current browser won't match the browser used when login.
function login_check() {
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if (isset($_SESSION['username'])) { // Check if username session variable currently is set.
		$username = $_SESSION['username'];
		if ($stmt = $mysqli->prepare("SELECT password_hash FROM members WHERE username = ? LIMIT 1")) { 
			$stmt->bind_param('s', $username); // Bind "$user_id" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			if($stmt->num_rows == 1) { // check if the user exists in the members table.
				$stmt->bind_result($password); // get stored password hash that was saved at creation.
				$stmt->fetch();
				$login_string = $_SESSION['login_string']; // gets the hashed password and client-browser type saved at login and used as session token.  
				$user_browser = $_SERVER['HTTP_USER_AGENT']; // gets the current client browsertype.
				$login_check = hash('sha512', $password.$user_browser); // create a new hash of the old previously entered password along with the current user browser type.
				if($login_check == $login_string) { // check if current browser type still are the same as at login. This protects against session hijacking.
					return true; 
				} // Another browser is used! Something strange is going on!
			}  // Could not find username in db...
		}  // sql syntax error
	}
	return false;// No one is yet logged in!
}

// Resets current sessuin-cookie and destroys it!
// @return known message to client javascript
function logout_user(){
	sec_session_start(); 
	$_SESSION = array(); // Unset all session values
	$params = session_get_cookie_params(); // get session parameters 
	// Delete the actual cookie.
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	session_destroy();
	echo "user_logged_out";
	die();
}

//function to check if a product actually exists in the products table.
// @return	TRUE:	when product id exists
// @return	FALSE:	when product id doesn't exist.
function productExists($product_id) {
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?")) {
		$stmt->bind_param('d', $product_id);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			return TRUE;
		}
	}
	return FALSE;
}
?>
