<?php
if (login_check()){
	if($_SESSION['cart']){
		unset($_SESSION['cart']);
	}
	echo "<div id='payment-success-container'><h2>Thank you for your purchase!</h2>";
	echo "<div>Here's your ordernumber:</br> <strong>6548136513</strong><br><br>Your items will be shipped shortly.</div></div>";
}else{
	echo "<div id='payment-success-container'><h2>Error!</h2>";
	echo "<div>You are currently <strong>not</strong> logged in <br> Your purchase did not succeed!</div></div>";
}