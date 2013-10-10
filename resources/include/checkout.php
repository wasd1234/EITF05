<?php
if (login_check()){
	if($_SESSION['cart']){
		echo "<div id='sb-checkout-container'>";
		echo "<h2>Checkout</h2>";
		echo "<h5>You are about to order the following items:</h5>";
	    echo "<table>";
	    $total_price = 0;
	    foreach($_SESSION['cart'] as $product_id => $quantity) { // Iterate trough the session cart.
	        // Gets the name, description and price from the products table.
	        // Use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
	        $sql = sprintf("SELECT name, description, price FROM products WHERE id = %d;", $product_id); 
			$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
			$result = $mysqli->prepare($sql);
			$result->execute(); 
			$result->store_result();
			$result->bind_result($name, $description, $price); 
			while ($result->fetch()) {
		        $line_cost = $price * $quantity; //work out the line cost
		        $total_price = $total_price + $line_cost; //add to the total cost
		        echo "<tr>";
		        //show this information in table cells
		        echo "<td>$name</td>";
		        //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
		        echo "<td align=\"center\">$quantity</td>";
		        echo "<td>$line_cost €</td>";
				echo "<td><input id='btn-co-rm-product-" . $product_id . "' data-prod-id='" . $product_id ."' class='btn-rm-from-cart' type='submit' name='Submit' value='Remove'></td>";
		        echo "</tr>";
		    }
	    }
	
	    //show the total
	    echo"<tr class='blank_row'><td colspan='3'></td></tr>";
	    echo "<tr>";
	    echo "<td colspan=\"2\" align=\"left\"><strong>Total</strong></td>";
	    echo "<td align='right'><strong>$total_price €</strong></td>";
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
		echo "<div><h2>Sorry m8!</h2>";
		echo "<div>Currently you have <strong>no</strong> items in your cart</div></div>";
	}
}else{
	echo "<div><h2>Error!</h2>";
	echo "<div>You are currently <strong>not</strong> logged in</div></div>";
}