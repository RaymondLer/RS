<?php 
include'_config.php';
$page->title='Cart List';
$page->header();
echo "<link rel='stylesheet' href='/css/footer.css'>";
?>


<form>
    <h1>Cart List</h1>
    <table> 
    <tr>
        <th>Item</th>
        <th>Product Price</th>
         <th>Total Price</th>
        <th>Order</th>
    </tr>
    <tr>
        <td></td>
    </tr>
    </table>
</form>







<?php 
$page->footer();
?>