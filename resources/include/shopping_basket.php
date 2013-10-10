<?php 
// Followed his guide
// http://jameshamilton.eu/content/simple-php-shopping-cart-tutorial
if (login_check()){
	if(! empty($_SESSION['cart'])){
	    echo "<table>"; //format the cart using a HTML table
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
	            echo "<td class='sb-col-2'>$quantity</td>";
	            echo "<td class='sb-col-3'>$line_cost €</td>";
				echo "<td class='sb-col-4'><input id='btn-rm-product-" . $product_id . "' data-prod-id='" . $product_id ."' class='btn-rm-from-cart' type='submit' name='Submit' value='Remove'></td>";
	            echo "</tr>";
	        }
	    }
	    //show the total
	    echo"<tr class='blank_row'><td colspan='3'></td></tr>";
	    echo"<br>";
	    echo "<tr>";
	    echo "<td colspan=\"2\" align=\"left\"><strong>Total</strong></td>";
	    echo "<td colspan=\"2\" align=\"left\"><strong>$total_price €</strong></td>";
	    echo "</tr>";
	
	    //show the empty cart link - which links to this page, but with an action of empty. A simple bit of javascript in the onlick event of the link asks the user for confirmation
	    echo "<tr>";
		echo "<td><input id='btn-empty-cart' type='submit' value='Empty cart'></td>";
		echo "<td><input id='btn-checkout-cart' type='submit' value='Checkout'/></td>";
		// echo "<td><input id='btn-checkout-cart' type='submit' name='Submit' value='Checkout'></td>";
	    echo "</tr>"; 
	    echo "</table>";
	}else{
		echo "<div>You currently have <strong>no</strong> items in your cart</div></div>";
	}
}else{
	echo "<div><h2>Error!</h2>";
	echo "<div>You are currently <strong>not</strong> logged in</div></div>";
}