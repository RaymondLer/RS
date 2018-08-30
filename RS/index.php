<?php
include'_config.php';
$page->title = 'Main';
$page->header();
echo '<link rel="stylesheet" href="/css/index.css">';

// b and c
$g = $c = $b = "";
$check = false;
$home = false;
if ($page->get('b') != '') {
    $b = $page->get('b');
} else if ($page->get('g') != "") {
    $check = true;
    $g = $page->get('g');
    $c_temp = $page->get('c');
    $c = str_replace('&amp;', '&', $c_temp);
} else if ($page->get('c') != "") {
    $c_temp = $page->get('c');
    $c = str_replace('&amp;', '&', $c_temp);
} else {
    $home = true;
}
$pdo = $page->pdo();
if ($home == true) {
    $stm = $pdo->query("SELECT * FROM product");
} else {
    if ($check === true) {
        $stm = $pdo->prepare("SELECT * FROM product
                      WHERE gender = ? AND category = ?");
        $stm->execute([$g, $c]);
    } else {
        $stm = $pdo->prepare("SELECT * FROM product
                          WHERE brand = ? OR category = ?");
        $stm->execute([$b, $c]);
    }
}
$product = $stm->fetchAll();
$ss = $pdo->query("SELECT DISTINCT brand
                    FROM product
                    ORDER BY brand");
$rows = $ss->fetchAll();
$sy = $pdo->query("SELECT DISTINCT category
                    FROM product
                    ORDER BY category");
$category = $sy->fetchAll();
?>

<body>
    <p class="warning"><?= $page->temp('warning') ?></p>
     <p class="success"><?= $page->temp('success') ?></p>
    <div class="wrap">
        <div id="aside">
            <h2>Brands</h2>
            <ul>
                <?php foreach ($rows as $row): ?>
                    <li>
                        <a href='?b=<?= $row->brand; ?> '> <?= $row->brand; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h2>Category</h2>
            <ul>
                <?php
                foreach ($category as $row):
                    $category = urlencode($row->category);
                    ?>
                    <li>
                        <a href='?c=<?= $category; ?> '> <?= $row->category; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="section"><h1>
                <?php
                if ($b == "" && $c != "" && $g == "")
                    echo $c;
                else if ($b != "" && $c == "" && $g == "")
                    echo $b;
                else if ($g != "" && $c != "") {
                    echo $g . "-" . $c;
                }
                ?>
            </h1>
            <?php foreach ($product as $a) { ?>
                <a href="/product.php?id=<?= $a->product_id ?>"><form id="product">
                        <div class="product_pic">
                            <img src="/post_product/<?= $a->product_id ?>.jpg">
                        </div>
                        <div id="container_name_price">
                            <div class="product_name">
                                <?= $a->name ?>
                            </div>
                            <div class="product_price">
                                RM <?= $a->price ?>
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
        </div>
    </div>
</body>

<?php
$page->footer();
?>