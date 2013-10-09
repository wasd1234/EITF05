<?php
	
	// HERE'S HOW OUR PROJECT IS STRUCTURED -> http://net.tutsplus.com/tutorials/php/organize-your-next-php-project-the-right-way/
	require_once("resources/config.php");
    require_once(INCLUDE_PATH . "/functions.php");
	require_once(TEMPLATES_PATH . "/header.php");
?>
	<div id="content">
	<?php
	    if(isset($_GET['page'])) {
	        $page = $_GET['page'];
	    } else {
	        $page = NULL;
	    }
	    switch($page) {
	        case 'create_user':
	            $page = 'create_user';
	            break;
	        case 'login_success':
	            $page = 'login_success';
	            break;
	        case 'products':
	            $page = 'products';
	            break;
	        case 'contact':
	            $page = 'contact';
	            break;
	        case 'lost_password':
	            $page = 'lost_password';
	            break;
	        case 'checkout':
	            $page = 'checkout';
	            break;
	        case 'create_payment':
	            $page = 'create_payment';
	            break;
	        case 'payment_success':
	            $page = 'payment_success';
	            break;
	        default:
	            $page = 'home';
	            break;
	    }
		
	    require_once(INCLUDE_PATH . "/$page.php");
	?>
	</div>
	<?php
		require_once(TEMPLATES_PATH . "/rightPanel.php");
		// require_once(TEMPLATES_PATH . "/footer.php");
