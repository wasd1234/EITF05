<?php
defined("INCLUDE_PATH")  
    or define("INCLUDE_PATH", realpath(dirname(__FILE__) . '/include'));  
      
defined("TEMPLATES_PATH")  
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates')); 
	

	
	// $db = new mysqli(ini_get('mysql.default_host'),
                     // ini_get('mysql.default_user'),
                     // ini_get('mysql.default_password'),
                     // ini_get('mysql.default_dbName')); 
	// if ($mysqli->connect_errno) {
    // echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
// }
// 	
	
	
	
	
	// $db_info = array(
	// $host=>"mysql.default_host", // Host name
	// $username=>"mysql.default_user", // Mysql username
	// $password=>"mysql.default_password", // Mysql password
	// $db_name=>"mysql.default_dbName", // Database name
	// ['tbl_name'] => "members",
	// ); // Table name
	// mysqli_connect($host, $username, $password)or die("cannot connect to mysql database"); 
	// mysql_select_db("$db_name")or die("cannot select DB");
// 	
//VIKTIGT!
	// 1. remember that anyone who can read that file will know your SQL password: set it not readable by others
	// 2. don't login with root: create a user for each application
	// 3. don't use "root" as your root password
	// 4. don't give your password to everyone