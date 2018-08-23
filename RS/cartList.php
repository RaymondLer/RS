<?php 
include'_config.php';
$page->title='Cart List';
$page->header();
echo "<link rel='stylesheet' href='/css/footer.css'>";
echo "<link rel='stylesheet' href='/css/cartList.css'>";
?>

// Get the product list from the data base
<?php 
$quantity = 0;
$item = 0;
$price = 0;
$totalPrice = 0;
$aQuantity = 10;
?>
<h1>Cart List</h1>
<table class="cartList"> 
<tr>
    <th>Item</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total Price</th>
    <th>Order</th>
</tr>
<tr>
    <td><?php $html->hidden('item',$item)?></td>
    <td><?php $html->hidden('price',$price)?></td>
    <td><?php $html->select('quantity',$aQuantity,$quantity,false)?></td>
    <td><?php $html->hidden('totalPrice',$totalPrice)?></td>
    <td></td>
</tr>
<tr>
    <td>Item</td>
    <td>Product Price</td>
    <td>Quantity</td>
    <td>Total Price</td>
    <td>Order</td>
</tr><tr>
    <td>Item</td>
    <td>Product Price</td>
    <td>Quantity</td>
    <td>Total Price</td>
    <td>Order</td>
</tr>
<tr>
    <td>Item</td>
    <td>Product Price</td>
    <td>Quantity</td>
    <td>Total Price</td>
    <td>Order</td>
</tr>


</table>








<?php 
$page->footer();
?>