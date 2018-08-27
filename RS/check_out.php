<?php
include'_config.php';

//if ($page->user->is_customer) {
//    
//}

$username = $card = $address = '';
$err = [];
$pdo = $page->pdo();

// TODO (2): Calculate total payment
$stm = $pdo->query("SELECT product_id, price FROM product");
$prices = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

$total_payment = 0.00;
foreach($cart->items as $product_id => $quantity) {
    $total_payment += $quantity * $prices[$product_id];
    var_dump($cart->items);
}

if ($page->is_post()) {
    //$order_id       = $page->post('order_id');
    $username       = $page->post('username');
    $card           = $page->post('card');
    $address        = $page->post('address');
    
     if ($username == '') {
        $err['username'] = 'Username is required.';
    }
    else if (strlen($username) > 20) {
        $err['username'] = 'Username must not more than 20 characters.';
    }
    
    if ($card == '') {
        $err['card'] = 'Credit Card Number is required.';
    } 
    else if (!preg_match('/^\d{16}$/', $card)) {
        $err['card'] = 'Credit Card Number format is invalid.';
    }

    if ($address == '') {
        $err['address'] = 'Delivery Address is required.';
    } 
    else if (strlen($address) > 255) {
        $err['address'] = 'Delivery Address must less than 255 characters.';
    }

    if (!$err) {
        // Everything is OK --> Add order
        // TODO (3): Add order
        $stm = $pdo->prepare("
            INSERT INTO `order` (username, card, address, total_payment, date)
            VALUES (?, ?, ?, ?, ?) 
        ");
        $stm->execute([$page->user->name, $card, $address, $total_payment, $page->date->format("Y-m-d")]);
    
    // TODO (4): Add order details
        $order_id = $pdo->lastInsertId();
        $stm = $pdo->prepare("
            INSERT INTO order_detail (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        foreach($cart->items as $product_id => $quantity) {
            $stm->execute([$order_id, $product_id, $quantity, $prices[$product_id]]);
        }
        
            // TODO (5): Clear shopping cart
            $cart->clear();

            $page->temp('success', 'Order added.');
            $page->redirect("/orderList.php?id=$order_id");
        }
    }

$page->title = 'Check out';
$page->header();
echo '<link rel="stylesheet" href="/css/check_out.css">';
?>

<form method="post">
    <div>
        <h2>Checkout</h2>
        <section>
            <div>
                <label for="username">Username:</label>
                <?php $html->text('username', $username, 20, 'autofocus') ?>
                <?php $html->error($err, 'username') ?>
            </div>

            <div>
                <label for="card">Debit/Credit Card Number:</label>
                <?php $html->text('card', $card, 16) ?>
                <?php $html->error($err, 'card') ?>
            </div>

            <div>
                <label for="address">Address:</label>
                <?php $html->textArea('address', $address, 4, 3) ?>
                <?php $html->error($err, 'address') ?>
            </div>

            <div class="calculate_total">
                <!-- total-->
            </div>
            <button id="button">Order Now</button>
        </section>
    </div>
</form>    

<?php
$html->focus('code', $err);
$page->footer();
?>