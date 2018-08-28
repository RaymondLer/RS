<?php 
include'../_config.php';
$page->title='Product Submit';
$page->header();

$pdo = $page->pdo();
$stm = $pdo->query("SELECT * FROM `order` ORDER BY date");
$order = $stm->fetchAll();
?>
<body>
    <section>
        <table>
        <tr>
            <th>Date</th>
            <th>Order Id</th>
            <th>Address</th>
            <th>Total Payment</th>
        </tr>
    <?php foreach ($order as $p) {?>
    <tr>
        <td><?= $p->date?></td>
        <td><a href='/admin/admin_order_details.php?oi=<?= $p->order_id?>'><?= $p->order_id?></a></td>
        <td><?= $p->address?></td>
        <td><?= $p->total_payment?></td>
    </tr>
    <?php }?>
        </table>
    </section>
<?php 
$page->footer();
?>