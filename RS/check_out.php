<?php
include'_config.php';
echo "<link rel='stylesheet' href='/css/check_out.css'>";
echo '<link rel="stylesheet" href="/css/site.css">';

$order_id = $username = $card = $address = $name = $email = "";
$err = [];
$pdo = $page->pdo();

// TODO (2): Calculate total payment
$stm = $pdo->query("SELECT product_id, price FROM product");
$prices = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

$total_payment = 0.00;
foreach ($cart->items as $product_id => $quantity) {
    $total_payment += $quantity * $prices[$product_id];
}
// Take the information from customer account
if ($page->user) {
    $cc = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
    $cc->execute([$page->user->name]);
    $customer = $cc->fetch();
}

if ($page->is_post()) {
    $order_id = $page->post('order_id');
    $username = $page->post('username');
    $name = $page->post('name');
    $email = $page->post('email');
    $card = $page->post('card');
    $address = $page->post('address');

    if ($name == '') {
        $err['name'] = 'Name is required.';
    } else if (strlen($name) > 100) {
        $err['name'] = 'Name must not more than 100 characters.';
    }
    if ($email == '') {
        $err['email'] = 'Email is required.';
    } else if (strlen($email) > 100) {
        $err['email'] = 'Email no more than 100 characters.';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $err['email'] = 'Email format invalid.';
    }
    if ($username == '') {
        $err['username'] = 'Username is required.';
    } else if (strlen($username) > 20) {
        $err['username'] = 'Username must not more than 20 characters.';
    }

    if ($card == '') {
        $err['card'] = 'Credit Card Number is required.';
    } else if (!preg_match('/^\d{16}$/', $card)) {
        $err['card'] = 'Credit Card Number format is invalid.';
    }

    if ($address == '') {
        $err['address'] = 'Delivery Address is required.';
    } else if (strlen($address) > 255) {
        $err['address'] = 'Delivery Address must less than 255 characters.';
    }

    if (!$err) {
        // Everything is OK --> Add order
        // TODO (3): Add order
        $stm = $pdo->prepare("
            INSERT INTO `order`(order_id, username, card, address, total_payment, date,name,email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
        ");
        $stm->execute([$order_id, $username, $card, $address, $total_payment, $page->date->format("Y-m-d"), $name, $email]);

        // TODO (4): Add order details
        $stm = $pdo->prepare("
            INSERT INTO order_detail(order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        foreach ($cart->items as $product_id => $quantity) {
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
?>

<body>
    <section>
        <form method="post">
            <div class="checkout">
                <h2>Checkout</h2>
                <?php $html->hidden('order_id', $order_id) ?>
                <div class="checkout1">
                    <?php
                    if ($page->user) {
                        $username = $page->user->name;
                        $html->hidden('username', $username);
                    } else {
                        $username = "notcustomer";
                        $html->hidden('username', $username);
                    }
                    ?>         
                </div>

                <div class="checkout1">
                    <label for="name">Name :</label>
                    <?php
                    if ($page->user) {
                        $html->hidden('name', $customer->name);
                        $html->error($err, 'name');
                        echo $customer->name;
                    } else {
                        $html->text('name', $name, 100);
                        $html->error($err, 'name');
                    }
                    ?>
                </div>

                <div class="checkout1">
                    <label for="email">Email : </label>
                    <?php
                    if ($page->user) {
                        $html->hidden('email', $customer->email);
                        $html->error($err, 'email');
                        echo $customer->email;
                    } else {
                        $html->text('email', $email, 100);
                        $html->error($err, 'email');
                    }
                    ?>
                </div>

                <div class="checkout1">
                    <label for="card">Debit/Credit Card Number :</label>
                    <?php $html->text('card', $card, 16) ?>
                    <?php $html->error($err, 'card') ?>
                </div>

                <div class="address">
                    <label for="address">Address :</label>
                    <?php $html->textArea('address', $address, 50, 6, 'style="text-align: left;"') ?>
                    <?php $html->error($err, 'address') ?>
                </div>

                <div class="calculate_total">
                    <!-- total-->
                </div>

                <div style="text-align: right;">
                    <button id="button">Order Now</button>
                </div>
            </div>
        </form>
    </section>
</body>    

<?php
$html->focus('username', $err);
$page->footer();
?>