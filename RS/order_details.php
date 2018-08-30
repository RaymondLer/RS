<?php
include'_config.php';
echo "<link rel='stylesheet' href='/css/admin/admin_order_details.css'>";


$username = $check = "";
$order_id = $page->get('oi');
$check = $page->get('check');
if ($page->user) {
    $username = $page->user->name;
} else {
    $username = "notcustomer";
}
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM `order` WHERE order_id = ? AND username = ?");
$stm->execute([$order_id, $username]);
$order = $stm->fetch();


$p = $pdo->query("SELECT product_id, name FROM product");
$product = $p->fetchAll();

$ss = $pdo->prepare("SELECT * FROM order_detail WHERE order_id = ? ORDER BY product_id");
$ss->execute([$order_id]);
$order_d = $ss->fetchAll();
if ($order == "" || $ss == "") {
    $page->redirect("/");
}
$page->title = 'Product Submit';
$page->header();
?>

<body>
    <section>
        <p class="success"><?= $page->temp('success') ?></p>
        <h1>
            Order Details
        </h1>
        <div id='wrap'>

            <table id='up'>
                <tr>
                    <th>Date</th>
                    <td><?= $order->date ?></td>
                </tr>
                <tr>
                    <th>Order Id</th>
                    <td><?= $order->order_id ?></td
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?= $order->address ?></td>
                </tr>
                <tr
                    ><th>Total Payment (RM)</th>
                    <td><?= $order->total_payment ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?= $order->name ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $order->email ?></td>
                </tr>


            </table>
            <h2>
                Product in The Order
            </h2>
            <table id='down'>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (RM)</th>

                </tr>
                <?php foreach ($order_d as $a) { ?>
                    <tr>
                        <td><?= $a->product_id ?></td>
                        <td><?php
                            foreach ($product as $p) {
                                if ($a->product_id == $p->product_id) {
                                    echo $p->name;
                                    break;
                                }
                            }
                            ?></td>
                        <td><?= $a->quantity ?></td>
                        <td><?= $a->price ?></td>

                    </tr>
                <?php } ?>
            </table>
            <?php if ($check == true) { ?>
                <div id='back'>
                    <a href='/orderList.php' ><button>Back</button></a>
                </div>
            <?php } ?>
    </section>
    
    <?php
    $page->footer();
    ?>