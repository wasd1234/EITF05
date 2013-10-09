<div id="right-panel">
<h2>Shopping Cart</h2>
<?php
	if(login_check()){
		require_once(INCLUDE_PATH . "/shopping_basket.php");
	}else{
		echo"<p>You are not logged in!</p>";
	}
?>
</div>