<?php 
include'_config.php';
$page->title='Product Submit';
$page->header();

$username = $page->user->name;
if($username ==""){
    echo "the username is not found";
}else{
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM `order` WHERE username = ? ORDER BY date");
    $stm->execute([$username]);
    $order = $stm->fetchAll();
}
?>
<body>
    <section>
        <div id='table_header'>
            <div>Date</div>
            <div>Order Id</div>
            <div>Username</div>
            <div>Card</div>
            <div>Address</div>
            <div>Total Payment</div>
        </div>
        <?php foreach ($order as $p) { ?>
            <a href='/admin/admin_order_details.php?oi=<?= $p->order_id ?>'>
                <div id='table_content'>
                    <div><?= $p->date ?></div>
                    <div><?= $p->order_id ?></div>
                    <div><?= $p->username ?></div>
                    <div><?= $p->card ?></div>
                    <div><?= $p->address ?></div>
                    <div><?= $p->total_payment ?></div>
                </div>
            </a>
        <?php } ?>
     
    </section>
<?php 
$page->footer();
?>