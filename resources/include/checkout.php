<?php
if (login_check() && $_SESSION['cart']){
// if(false){
	echo "<div id='sb-checkout-container'>";
	echo "<h2>Checkout!</h2>";
	echo "<p>Are you sure you want to order the following items?</p>";
    echo "<table>"; //format the cart using a HTML table

    //iterate through the cart, the $product_id is the key and $quantity is the value
    $total = 0;
    foreach($_SESSION['cart'] as $product_id => $quantity) { 

        //get the name, description and price from the database - this will depend on your database implementation.
        //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
        $sql = sprintf("SELECT name, description, price FROM products WHERE id = %d;", $product_id); 
		$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        // $result = mysql_query($sql);
		$result = $mysqli->prepare($sql);
		// $stmt->bind_param('s', $username); 
		$result->execute(); 
		$result->store_result();
		$result->bind_result($name, $description, $price); 
		// $result->fetch();
		while ($result->fetch()) {
            $line_cost = $price * $quantity; //work out the line cost
            $total = $total + $line_cost; //add to the total cost
            echo "<tr>";
            //show this information in table cells
            echo "<td align=\"center\">$name</td>";
            //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
            echo "<td align=\"center\">$quantity <a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\">X</a></td>";
            echo "<td align=\"center\">$line_cost</td>";
			echo "<td><input id='btn-product-" . $product_id . "' data-prod-id='" . $product_id ."' class='btn-rm-from-cart' type='submit' name='Submit' value='Remove'></td>";
            echo "</tr>";
        }
    }

    //show the total
    echo "<tr>";
    echo "<td colspan=\"2\" align=\"right\">Total</td>";
    echo "<td align='right'>$total</td>";
    echo "</tr>";
    echo "<tr>";
	echo "<td><h3>Choose payment:<h3></td>";
	echo "<td><label for='btn-payment-visa'>Visa<br></label><input id='btn-payment-visa' type='radio' /></td>";
	echo "<td><label for='btn-payment-paypal'>PayPal</label><input id='btn-payment-paypal' type='radio' /></td>";
	// echo "<td><input id='btn-checkout-cart' type='submit' name='Submit' value='Checkout'></td>";
    echo "</tr>"; 
    echo "<tr>";
	echo "<td><input id='btn-checkout-back' class='btn-return-to-products' type='submit' value='Continue shopping'></td>";
	echo "<td><input id='btn-checkout-final' type='submit' value='Finish'/></td>";
	// echo "<td><input id='btn-checkout-cart' type='submit' name='Submit' value='Checkout'></td>";
    echo "</tr>"; 
	echo "</table>";
	echo "</div>";
}else{
	echo "<div id='login-success-container'><h2>Error!</h2>";
	echo "<div>You are currently <strong>not</strong> logged in</div></div>";
}