<?php 
// Followed his guide
// http://jameshamilton.eu/content/simple-php-shopping-cart-tutorial

// echo print_r($_SESSION['bookingflow_sess']['cart'], true);
if(! empty($_SESSION['cart']) ) { //if the cart isn't empty
//show the cart

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
            echo "</tr>";

        }

    }

    //show the total
    echo "<tr>";
    echo "<td colspan=\"2\" align=\"right\">Total</td>";
    echo "<td align=\"right\">$total</td>";
    echo "</tr>";

    //show the empty cart link - which links to this page, but with an action of empty. A simple bit of javascript in the onlick event of the link asks the user for confirmation
    echo "<tr>";
    echo "<td colspan=\"3\" align=\"right\"><a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a></td>";
    echo "</tr>"; 
    echo "</table>";



}else{
//otherwise tell the user they have no items in their cart
    echo "You have no items in your shopping cart.";
} 