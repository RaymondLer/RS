<?php
include '_config.php';
echo "<link rel='stylesheet' href='/css/search.css'>";
$page->title = 'Product Submit';
$page->header();

$count = 0;
$name = $page->get('search');
if ($page->get('search') == '') {
    $page->temp('warning', 'Result not found');
    $page->redirect('/');
}
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE product_id LIKE ? OR name LIKE ? OR brand LIKE ? OR category LIKE ?");
$stm->execute(["%$name%", "%$name%", "%$name%", "%$name%"]);
$product = $stm->fetchAll();
if ($product == null) {
    $page->temp('warning', 'Result not found.');
    $page->redirect('/');
}
foreach ($product as $p) {
    $count++;
}
$a = '';
$pdo = $page->pdo();
$stm = $pdo->query("SELECT * FROM product");
$p = $stm->fetchAll();
?>
<body>
    <div id="wrap">
        <section>
            <h2>Searching for "<?= $name ?>"</h2>
            <h3><?= $count ?> record(s) is found</h3>
            <?php foreach ($product as $a) { ?>
                <a href="/product.php?id=<?= $a->product_id ?>">
                    <form id="product">
                        <div class="product_pic">
                            <img src="/post_product/<?= $a->product_id ?>.jpg">
                        </div>
                        <div id="container_name_price">
                            <div class="product_name">
                                <?= $a->name ?>
                            </div>
                            <div class="product_price">
                                RM<?= $a->price ?>
                            </div>
                        </div>
                        <div class="category">
                            <?= $a->category ?>
                        </div>
                        <div class="gender">
                            <?= $a->gender ?>
                        </div>
                    </form>
                </a>
            <?php } ?>


        </section>
    </div>
    <?php
    $page->footer();
    ?>
