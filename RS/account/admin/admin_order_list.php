<?php
include'../../_config.php';
echo "<link rel='stylesheet' href='/css/admin/admin_order_list.css'>";
$page->title = 'Order List';
$page->header();

$pdo = $page->pdo();
$stm = $pdo->query("SELECT * FROM `order` ORDER BY date");
$order = $stm->fetchAll();
?>
<body>
    <section>
        <div class='wrap'>
            <h2>
                All Customer Order List
            </h2>
        <table>
        <tr>
            <th>Date</th>
            <th>Order Id</th>
            <th>Username</th>
            <th>Card</th>
            <th>Address</th>
            <th>Total Payment</th>
            <th></th>
        </tr>
        <?php foreach ($order as $p) { ?>
            <tr>
                    <td><?= $p->date ?></td>
                    <td><?= $p->order_id ?></td>
                    <td><?= $p->username ?></td>
                    <td><?= $p->card ?></td>
                    <td><?= $p->address ?></td>
                    <td><?= $p->total_payment ?></td>
                    <td><a href='/account/admin/admin_order_details.php?oi=<?= $p->order_id?>'><button class='btn'>Details</button></a></td>
            </tr>
        <?php } ?>
        </table>
        </div>
    </section>
    <?php
    $page->footer();
    ?>