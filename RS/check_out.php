<?php
include'_config.php';

$username = $card = $code = $phone = $address = '';
$err = [];
$pdo = $page->pdo();

// TODO (2): Calculate total payment
$stm = $pdo->query("SELECT id, price FROM product");
$prices = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

$payment = 0.00;
foreach($cart->items as $product_id => $quantity) {
    $payment += $quantity * $prices[$product_id];
}

if ($page->is_post()) {
    $username = $page->post('username');
    $card = $page->post('card');
    $code = $page->post('code');
    $phone = $page->post('phone');
    $address = $page->post('address');

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

    if ($code == '') {
        $err['code'] = 'Card Security Code is required.';
    } 
    else if (!preg_match('/^\d{3}$/', $code)) {
        $err['code'] = 'Card Security code format is invalid.';
    }

    if ($phone == '') {
        $err['phone'] = 'Phone is required.';
    } 
    else if (!preg_match('/^01\d-\d{7,8}$/', $phone)) {
        $err['phone'] = 'Phone format invalid.';
    }

    if ($address == '') {
        $err['address'] = 'Delivery Address is required.';
    } 
    else if (strlen($address) > 255) {
        $err['address'] = 'Delivery Address must less than 255 characters.';
    }

    if (!err) {
        // Everything is OK --> Add order
        // TODO (3): Add order
        $stm = $pdo->prepare("
            INSERT INTO `order` (username, date, payment, card, code, address)
            VALUES (?, ?, ?, ?, ?, ?) 
        ");
        $stm->execute([$page->user->name, $page->date->format("Y-m-d"), $payment, $card, $code, $address]);
    }
}

$page->title = 'Check out';
$page->header();
echo '<link rel="stylesheet" href="/css/check_out.css">';
?>

<form method="post">
    <div class="form">
        <aside>
            <h2>Checkout</h2>
        </aside>
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
                <label for="code">Security Number:</label>
                <?php $html->text('code', $code, 3) ?>
                <?php $html->error($err, 'code') ?>
            </div>

            <div>
                <label for="phone">Contact Number:</label>
                <?php $html->text('phone', $phone, 12) ?>
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
$html->focus('card', $err);
$page->footer();
?>