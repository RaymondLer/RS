<?php 
include'_config.php';

$id = $page->get('id');
$pdo = $page->pdo();
//$username = $page->user->name;

$stm = $pdo->prepare("SELECT * FROM `order` WHERE order_id = ? AND username = ?");
$stm->execute([$order_id, $page->user->name]);
var_dump($id);
$order = $stm->fetch();

if ($order) {
    $stm = $pdo->prepare("
        SELECT p.product_id, p.name
               o.price, o.quantity, (o.price * o.quantity) AS subtotal
        FROM product AS p, order_detail AS o
        WHERE p.product_id = o.product_id AND o.order_id = ?
    ");
    $stm->execute([$product_id]);
    $items = $stm->fetchAll();
}
//else {
//    $page->redirect('/');
//}

$page->title='Order List';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<h1>Order List</h1>
<div class="form">
    <div>
        
        <label>Order Id</label>
        <div><?= $order->order_id ?></div>
    </div>
    
    <div>
        <label>Date</label>
        <div><?= $order->date ?></div>
    </div>
    
    <div>
        <label>Payment</label>
        <div>RM<?= $order->total_payment ?></div>
    </div>
    
    <div>
        <label>Delivery Address</label>
        <div><?= $order->address ?>
    </div>
</div>

<br>
    
<table class="orderList">
    <tr>
        <th>Id</th>        
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    
    <?php foreach ($items as $item) : ?>
    <tr>
        <td><?= $item->product_id ?></td>
        <td><?= $item->name ?></td>
        <td><?= $item->price ?></td>
        <td><?= $item->quantity ?></td>
        <td><?= $item->subtotal ?></td>
    </tr>
    <?php endforeach; ?>
</table>








<?php 
$page->footer();
?>