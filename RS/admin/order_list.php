<?php 
//include('../database.php');
include'../_config.php';
$page->title='Product Submit';
$page->header();

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM `order` WHERE username = ?");
$stm->execute([]);
$product = $stm->fetchAll();

?>
<body>
    <?= $product->order_id?>
    <?php foreach ($product as $p) {?>
        <?= $p->?>
    }?>
    <?= $p->product_id?>
<?php 
$page->footer();
?>