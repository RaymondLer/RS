<?php
include'_config.php';

//if ($page->user->is_customer) {
//    
//}

$order_id = $username = $card = $address = $name = $email= "";
$err = [];
$pdo = $page->pdo();

// TODO (2): Calculate total payment
$stm = $pdo->query("SELECT product_id, price FROM product");
$prices = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

$total_payment = 0.00;
foreach($cart->items as $product_id => $quantity) {
    $total_payment += $quantity * $prices[$product_id];
}
// Take the information from customer account
$cc = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
$cc->execute([$page->user->name]);
$customer = $cc->fetch();
var_dump($customer);
if ($page->is_post()) {
    $order_id       = $page->post('order_id');
    $username       = $page->post('username');
    $name           = $page->post('name');
    $email          = $page->post('email');
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
            INSERT INTO `order`(order_id, username, card, address, total_payment, date)
            VALUES (?, ?, ?, ?, ?, ?) 
        ");
        $stm->execute([$order_id, $username, $card, $address, $total_payment, $page->date->format("Y-m-d")]);
    
    // TODO (4): Add order details
        var_dump($order_id);
        $stm = $pdo->prepare("
            INSERT INTO order_detail(order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        foreach($cart->items as $product_id => $quantity) {
            $stm->execute([$order_id, $product_id, $quantity, $prices[$product_id]]);
        }
        
            // TODO (5): Clear shopping cart
            $cart->clear();

            $page->temp('success', 'Order added.');
            $page->redirect("order_details.php?oi=$order_id");
        }
    }
$stm = $pdo->query("SELECT order_id FROM `order`");
$sa = $stm->fetchAll();
$order_id = 1000;
do {
    $try = false;
    $order_id++;
    foreach ($sa as $s) {
        if ($order_id == $s->order_id) {
            $try = true;
        }
    }
} while ($try);

$page->title = 'Check out';
$page->header();
echo '<link rel="stylesheet" href="/css/check_out.css">';
?>

<form method="post">
    <div>
        <h2>Checkout</h2>
        <section>
            <?php $html->hidden('order_id', $order_id) ?>
            <?= $order_id ?>
            <div>
                <?php if ($page->user) {
                    $username = $page->user->name;
                    $html->hidden('username', $username);
                    echo "Username: {$username}";
                }
//                else if (!$page->user) {
//                    echo "<label for='name'>Name :</label>"
//                    $html->text('username', $username, 20, 'autofocus');
//                    $html->error($err, 'username');
//                } ?>         
            </div>
            
            <div>
                <label for="name">Name :</label>
                <?php if ($page->user) {
                    $html->hidden('name', $customer->name, 20);
                    $html->error($err, 'name');
                    echo $customer->name;
                } else {
                    $html->text('name', $customer->name, 20);
                    $html->error($err, 'name');
                } ?>
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
$html->focus('username', $err);
$page->footer();
?>