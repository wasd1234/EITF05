<?php 

if($_SESSION['cart']) { //if the cart isn't empty
//show the cart

    echo "<table>"; //format the cart using a HTML table

    //iterate through the cart, the $product_id is the key and $quantity is the value
    foreach($_SESSION['cart'] as $product_id => $quantity) { 

        //get the name, description and price from the database - this will depend on your database implementation.
        //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
        $sql = sprintf("SELECT name, description, price FROM php_shop_products WHERE id = %d;", $product_id); 

        $result = mysql_query($sql);

        //Only display the row if there is a product (though there should always be as we have already checked)
        if(mysql_num_rows($result) > 0) {

            list($name, $description, $price) = mysql_fetch_row($result);

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