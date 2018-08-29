<?php
include '_config.php';
echo "<link rel='stylesheet' href='/css/search.css'>";
$page->title = 'Product Submit';
$page->header();

$name = $page->get('search');
if ($page->get('search') == '') {
    $page->temp('warning', 'The thing you search in not found');
    $page->redirect('main.php');
}
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE product_id LIKE ? OR name LIKE ? OR brand LIKE ? OR category LIKE ?");
$stm->execute(["%$name%", "%$name%", "%$name%", "%$name%"]);
$product = $stm->fetchAll();
if ($product == null) {
    $page->temp('warning', 'The thing searched not found.');
    $page->redirect('/');
}
$a = '';
$pdo = $page->pdo();
$stm = $pdo->query("SELECT * FROM product");
$p = $stm->fetchAll();
?>
<body>
    <div id="wrap">
        <?php foreach ($product as $p) { ?>
            <div id="row">
                <a class="product" href="product.php?id=<?= $p->product_id ?>">
                    <div class="product_pic">
                        <img src="/post_product/<?= $p->product_id ?>.jpg">
                    </div>

                    <div>
                        <?= $p->product_id ?>
                    </div>
                    <div>
                        <?= $p->brand ?>
                    </div>
                    <div>
                        <?= $p->price ?>
                    </div>
                    <div>
                        <?= $p->name ?>
                    </div>
                    <div>
                        <?= $p->category ?>
                    </div>
                    <div>
                        <?= $p->desc ?>
                    </div>
                </a>


            </div>
        <?php } ?>

    </div>
    <?php
    $page->footer();
    ?>
