<div id="products-container">
	<h2>Products</h2>
	<table>
		<thead>
		</thead>
		<tbody>
			<tr>
				<th>Produkt1</th>
				<th>Produkt2</th>
			</tr>
			<tr>
				<td><p>This is a <br> multi-line description <br>of</p></td>
				<td><p>This is another <br> multi-line description <br>of</p></td>
			</tr>
			<tr>
				<td>Price:</td>
				<td>Price:</td>
			</tr>
			<tr>
				<td>88€</td>
				<td>77€</td>
			</tr>
			<tr>
				<td><input id="btn-product-1" data-prod-id="1" class="btn-add-to-cart" type="submit" name="Submit" value="Add to cart"></td>
				<td><input id="btn-product-2" data-prod-id="2" class="btn-add-to-cart" type="submit" name="Submit" value="Add to cart"></td>
			</tr>
		</tbody>
	</table>
</div>
<?php
        // $sql = sprintf("SELECT name, description, price FROM products WHERE id = %d;", $product_id); 
		// $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        // // $result = mysql_query($sql);
		// $result = $mysqli->prepare($sql);
		// // $stmt->bind_param('s', $username); 
		// $result->execute(); 
		// $result->store_result();
		// $result->bind_result($name, $description, $price); 
		// // $result->fetch();
		// while ($result->fetch()) {
            // $line_cost = $price * $quantity; //work out the line cost
            // $total = $total + $line_cost; //add to the total cost
            // echo "<tr>";
            // //show this information in table cells
            // echo "<td align=\"center\">$name</td>";
            // //along with a 'remove' link next to the quantity - which links to this page, but with an action of remove, and the id of the current product
            // echo "<td align=\"center\">$quantity <a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\">X</a></td>";
            // echo "<td align=\"center\">$line_cost</td>";
			// echo "<td><input id='btn-product-" . $product_id . "' data-prod-id='" . $product_id ."' class='btn-rm-from-cart' type='submit' name='Submit' value='Remove'></td>";
            // echo "</tr>";
// 
        // }