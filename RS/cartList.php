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

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM cart WHERE username = ?");
$stm -> execute($user->name);
$cart = $stm->fetchAll();
?>
<?php if ($cart->items): ?>
<h1>Cart List</h1>
<table class="cartList"> 
<tr>
    <th>Item</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total Price</th>
</tr>

<?php foreach($cart as $a){ 
   $pdo = $page->pdo();
    $stm = $pdo->query("SELECT * FROM cart WHERE username = $a->item");
    $price = $stm->fetch();
?>

    <tr>
        <td><?php $html->hidden('item',$a->item)?></td>
        <td><?php $html->hidden('price',$price)?></td>
        <td><?php $html->select('quantity',range(0,9),$quantity,false)?></td>
        <td><?php $html->hidden('totalPrice',$totalPrice)?></td>
        <td><button id="delete">delete</button></td>
        <td></td>
    </tr>
    <?php  }?>
    <tr>
        <td><?php $html->hidden('item',$item)?></td>
        <td><?php $html->hidden('price',$price)?></td>
        <td><?php $html->select('quantity',$aQuantity,$quantity,false)?></td>
        <td><?php $html->hidden('totalPrice',$totalPrice)?></td>
        <td><button id="delete">delete</button></td>
        <td></td>
    </tr>
    <?php else:?>
    <p> The cart is empty</p>
    <?php endif?>

</table>








<?php 
$page->footer();
?>