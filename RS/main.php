<?php
include'_config.php';
$page->title = 'Main';
$page->header();
echo '<link rel="stylesheet" href="/css/main.css">';

// b and c
$array = [];
$check = false;
$home = false;
$b = $c = $g = "";
if ($page->get('b') != '') {
    $b = $page->get('b');
} else if ($page->get('g') != "") {
    $a = $page->get('g');
    if (strpos($a, 'c=')) {
        $check = true;
        $array = explode('&amp;c=', $a);
        $g = $array[0];
        $c = str_replace('&amp;', '&', $array[1]);
    } else {
        $g = $a;
        var_dump($g);
    }
} else if ($page->get('c') != '') {
    $c = $page->get('c', '', false);
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
        <div id="section"><h1 style="background:red">
                <?php
                if ($b == "" && $c != "")
                    echo $c;
                else if ($b != "" && $c == "")
                    echo $b;
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
                                RM<?= $a->price ?>
                            </div>
                        </div>
                        <div class="product_description">
                            <?= $a->category ?>
                        </div>
                        <div>
                            <?= $a->gender ?>
                        </div>

                    </form>
                </a>
            <?php } ?>




        </div>
    </div>
    <?php
    $page->footer();
    ?>