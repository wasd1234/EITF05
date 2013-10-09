<?php
if (login_check()){
	echo "<div id='login-success-container'><h2>Welcome!</h2>";
	echo "<div>You are currently logged in as: <strong>" . $_SESSION['username'] . "</strong></div></div>";
}else{
	echo "<div id='login-success-container'><h2>Error!</h2>";
	echo "<div>You are currently <strong>not</strong> logged in</div></div>";
}
