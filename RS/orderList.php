<?php 
include'_config.php';
$page->title='Order List';
$page->header();
?>


<form>
    <h1>Order List</h1>
    <table class="order_list">
        <tr>
            <th>product_id</th>
            <th>Order_id</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        
    </table>
</form>







<?php 
$page->footer();
?>