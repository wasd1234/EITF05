<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/public_html/js/scripts.js"></script>
	<link rel="stylesheet" type="text/css" href="/public_html/css/style.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Webshop</title>
</head>

<body>
<div id="header">
	<div id="site-top">
		<div id="nav-container">			
			<div id="site-heading">
				<h1>Webshop</h1>
			</div>
			<div id="site-menu">
			<ul id="nav-bar" class="nav">
				<li><a href="?page=home">Home</a></li>
				<li><a href="?page=products">Products</a></li>
				<li><a href="?page=contact">Contact us</a></li>
			</ul>
			</div>
		</div>
		<div id="site-login-container">
			<?php
			//TODO
				// if("user_logged_in" == TRUE){
				if(FALSE){
					echo "LOGGED IN AS USER:";
				}else{
					require_once(INCLUDE_PATH . "/login.php");
				}
			?>	
		</div>
	</div>
</div>