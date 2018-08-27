<?php

include'_config.php';
$page->title = 'Main';
$page->header();
echo '<link rel="stylesheet" href="/css/main.css">';

$b = $page->get('b');

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product
                      WHERE brand = ? OR 1 = ?");

$stm->execute([$b, $b == '']);
$students = $stm->fetchAll();
    
$stm = $pdo->query("SELECT DISTINCT brand
                    FROM product
                    ORDER BY brand");
$rows = $stm->fetchAll();

?>

<div>
    <a href="?">Brands</a>
    <?php
    foreach ($rows as $row) {
        echo " | <a href='?b=$row->brand'>$row->brand</a> ";
    }
    ?>
</div>

<table class="table">
    <tr>
        <th>Product Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Gender</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Size</th>
    </tr>
    <?php foreach ($students as $s): ?>
    <tr>
        <td><?= $s->product_id   ?></td>
        <td><?= $s->name         ?></td>
        <td><?= $s->price        ?></td>
        <td><?= $s->desc         ?></td>
        <td><?= $s->gender       ?></td>
        <td><?= $s->category     ?></td>
        <td><?= $s->brand        ?></td>
        <td><?= $s->size         ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
    $page->footer();
?>