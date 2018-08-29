<?php
include'../../_config.php';
$page->authorize('admin');
echo "<link rel='stylesheet' href='/css/admin/admin_order_details.css'>";
$page->title = 'Order Details';
$page->header();


$order_id = $page->get('oi');
if($order_id ==""){
    $page->redirect("/");
}
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM `order` WHERE order_id = ?");
$stm->execute([$order_id]);
$order = $stm->fetch();


$p = $pdo->query("SELECT product_id, name FROM product");
$product = $p->fetchAll();

$ss = $pdo->prepare("SELECT * FROM order_detail WHERE order_id = ? ORDER BY product_id");
$ss->execute([$order_id]);
$order_d = $ss->fetchAll();
?>
<body>
    <section>
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
            <div id='back'>
                <a href='/account/admin/admin_order_list.php' ><button>Back</button></a>
            </div>
    </section>

    <?php
    $page->footer();
    ?>