<?php 
include'_config.php';

// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $action = $page->post('action');
    
    if ($action == 'update') {
        $id = $page->post('id');
        $quantity = $page->post('quantity');
        $cart->set($id, $quantity);
        $page->redirect();
    }
    
    if ($action == 'clear') {
        $cart->clear();
        $page->redirect();
    }
    
    if ($action == 'checkout') {
        $page->redirect('checkout.php');
    }
    
}

// GET request -----------------------------------------------------------------
$ids = $cart->ids();
$in = '(' . str_repeat('?,', count($ids)) . '1)';

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT product_id, name, price FROM product WHERE id IN $in");
$stm->execute($ids);
$products = $stm->fetchAll();

$page->title='Cart List';
$page->header();
echo "<link rel='stylesheet' href='/css/footer.css'>";
echo "<link rel='stylesheet' href='/css/cartList.css'>";
?>

<!-- IF: Shopping cart NOT EMPTY ---------------------------------------------->
<?php if ($cart->items): ?>

<table class="table">
    <tr>
        <th>Id</th>        
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th></th>
    </tr>

    <?php
    // TODO
    $total_quantity = 0;
    $total = 0.00;
    
    foreach ($products as $a) {
        $quantity = $cart->get($a->id);
        $subtotal = $a->price * $quantity;
        
        $total_quantity += $quantity;
        $total += $subtotal;
    ?>
    
    <tr>
            <td>
                <a href="shoes.php?id=<?= $a->id ?>"><?= $a->id ?></a>
            </td>
            <td><?= $a->name ?></td>
            <td><?= $a->price ?></td>
            <td>
                <!-- TODO -->
                <form method="post" class="inline">
                    <?php $html->select('quantity', range(0, 10), $quantity, false, 'onchange = "this.form.submit()"') ?>
                    <?php $html->hidden('id', $a->id) ?>
                    <?php $html->hidden('action', 'update') ?>
                </form>
            </td>
            <td><?= number_format($subtotal, 2) ?></td>
            <td>
                <!--REMEMBER MODIFY-->
                <img class="cover" src="/product/Shoes/<?= $a->product_id ?>"> 
            </td>
        </tr>
    <?php } // END FOREACH ?>
        
    <tr>
        <th colspan="4"></th>
        <th><?= $total_quantity ?></th>
        <th><?= number_format($total, 2) ?></th>
        <th></th>
    </tr>
</table>

<p style="color: red">NOTE: Set quantity to 0 to remove item.</p>

<form method="post">
    <button name="action" value="clear">Clear</button>
    <button name="action" value="checkout">Checkout</button>
</form>

<!-- ELSE: Shopping cart EMPTY ------------------------------------------------>
<?php else: ?>

<p class="warning">Your shopping cart is empty.</p>

<?php endif; ?>
<!-- END IF ------------------------------------------------------------------->
    
<?php 
$page->footer();
?>