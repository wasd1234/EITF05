<?php
function sec_session_start() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure = true; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.  
}

function login($username , $password, $mysqli) {
	
   if ($stmt = $mysqli->prepare("SELECT username, password_hash, salt FROM members WHERE username = ?")) { 
      $stmt->bind_param('s', $username); 
      $stmt->execute(); 
      $stmt->store_result();
      $stmt->bind_result($username, $db_password, $salt); 
      $stmt->fetch();
	  	  
	$options = array('salt' => $salt);
	$password = password_hash($password, PASSWORD_BCRYPT, $options);
	
	
	
      if($stmt->num_rows == 1) { // Kollar om användaren fanns
         // Kollar så att inte accountet är låst
         if(checkbrute($username, $mysqli) == true) { 
            // accountet var låst, skicka email till användaren. 
            echo "User account is locked";
            return false;
         } else {
         if($db_password == $password) { 
 
 				
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
               // $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
               // $_SESSION['user_id'] = $user_id; 
               $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
               $_SESSION['username'] = $username;
               // $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
               // Login successful.
               
               	echo "User logged in successfully!1";	
               
               return true;    
         } else {
            // Lösenordet var fel, lägg in de misslyckade försöket i databasen.
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (username, time) VALUES ('$username', '$now')");
            
			echo 'wrong password';
            
            return false;
			
         }
      }
      }else{
         // Fel användarnamn 
         			echo 'wrong username';
         
         return false;
      		}
   		}
   }


function checkbrute($username, $mysqli) {


   $now = time();
   // Alla login försök från de senaste 3 min räknas in. 
   $valid_attempts = $now - (3 * 60); 
 
   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE username = ? AND time > '$valid_attempts'")) { 
      $stmt->bind_param('s', $username); 
      $stmt->execute();
      $stmt->store_result();
     
      if($stmt->num_rows > 5) {
         return true;
      } else {
      	//vid fler än fem inloggninsförsök retuneras false
         return false;
      }
   }
}

function login_check($mysqli) {
   // Check if all session variables are set
   if(isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
     if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) { 
        $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
 
        if($stmt->num_rows == 1) { // If the user exists
           $stmt->bind_result($password); // get variables from result.
           $stmt->fetch();
           $login_check = hash('sha512', $password.$user_browser);
           if($login_check == $login_string) {
              // Logged In!!!!
              return true;
           } else {
              // Not logged in
              return false;
           }
        } else {
            // Not logged in
            return false;
        }
     } else {
        // Not logged in
        return false;
     }
   } else {
     // Not logged in
     return false;
   }
}

function createuser($username, $passwordHash, $useremail, $useraddress, $salt, $mysqli) {
   
   if ($stmt = $mysqli->prepare("INSERT INTO members (username, password_hash, salt, address, useremail) VALUES (?, ?, ?, ?, ?)")) {
      	$stmt ->bind_param('sssss', $username, $passwordHash, $salt, $useraddress, $useremail ); 
      $stmt->execute(); // Execute the prepared query.
   }
   
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
