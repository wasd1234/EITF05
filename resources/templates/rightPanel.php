<div id="right-panel">
<?php
	if(login_check()){
		echo '<h2>Shopping Cart</h2>';
		require_once(INCLUDE_PATH . "/shopping_basket.php");
	}else{
		echo"<p>You are not logged in!</p>";
	}
?>
</div>