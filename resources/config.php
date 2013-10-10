<?php

// Define directories
defined("INCLUDE_PATH") 
	or define("INCLUDE_PATH", realpath(dirname(__FILE__) . '/include'));  // Where all included php-files are located
defined("TEMPLATES_PATH") 
	or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates')); // Where all templates are located

// Define Mysql-credentials
defined("HOST") 
	or define("HOST", "localhost"); // The hostname of the db.
defined("USER") 
	or define("USER", "root"); // The username.
defined("PASSWORD") 
	or define("PASSWORD", "r00tpass"); // And password. 
defined("DATABASE") 
	or define("DATABASE", "webshop"); // The default schema name.