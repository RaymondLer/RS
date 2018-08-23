<?php 
include'_config.php';
$page->title='Cart List';
$page->header();
echo "<link rel='stylesheet' href='/css/footer.css'>";
echo "<link rel='stylesheet' href='/css/cartList.css'>";
?>

// Get the product list from the data base
<h1>Cart List</h1>
<table class="cartList"> 
<tr>
    <th id="item">Item</th>
    <th id="price">Product Price</th>
    <th quatity="quantity">Quantity</th>
    <th id="tPrice">Total Price</th>
    <th id="order">Order</th>
</tr>
<tr>
    <td>asdj</td>
    <td>lkflg</td>
    <td>df</td>
    <td id="order">sdjf</td>
</tr>

<tr>
    <td>asdj</td>
    <td>lkflg</td>
    <td>df</td>
    <td>sdjf</td>
</tr>
</table>








<?php 
$page->footer();
?>