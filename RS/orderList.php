<?php
include'_config.php';
echo "<link rel='stylesheet' href='/css/admin/admin_order_list.css'>";

$page->title = 'Product Submit';
$page->header();
$page->authorize('customer');
$username = $page->user->name;
if ($username == "") {
    echo "the username is not found";
} else {
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM `order` WHERE username = ? ORDER BY date");
    $stm->execute([$username]);
    $order = $stm->fetchAll();
}
?>

<body>
    <section>
        <div class='wrap'>
            <h2>
                Order History
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
                        <td><a href='/order_details.php?oi=<?= $p->order_id ?>&check=true'><button class='btn'>Details</button></a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </section>
    
    <?php
    $page->footer();
    ?>