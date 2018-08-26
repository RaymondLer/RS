<?php 
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();


$s = $page->get('g');
echo utf8_decode(urldecode("Ant%20B4nio+Carlos+Jobim"));

echo utf8_decode(urldecode($s));
;

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR 1 = ?");
$stm->execute([$s, $s == '']);
$products = $stm->fetchAll();
$stm = $pdo->query("SELECT DISTINCT category
                        FROM product
                        ORDER BY category");
$rows = $stm->fetchAll();
?>
<body>
    <section>
        <div>
            <a href="?">All</a>
            <?php
            foreach ($rows as $row) {
                echo " | <a href='?g=$row->category'> $row->category</a> ";
            }
            ?>
        </div>
        <!--Search the things from category, id,name,description,brand-->
        <div>
            <?php $html->text('search')?>
        </div>
        <p><?= count($products) ?> record(s)</p>

        <table class="table">
            <tr>
                <th></th>
                <th>Product id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Gender</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Size</th>
            </tr>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><input type="checkbox" name="files[]" form="f" value="<?= $p->$product_id ?>"></td>
                <td><?= $p->product_id  ?></td>
                <td><?= $p->name        ?></td>
                <td><?= $p->price       ?></td>
                <td><?= $p->desc        ?></td>
                <td><?= $p->gender      ?></td>
                <td><?= $p->category    ?></td>
                <td><?= $p->brand       ?></td>
                <td><?= $p->size        ?></td>
                <td> <button > delete</button></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>


<?php 
$page->footer();
?>