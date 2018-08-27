<?php 
include '_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

    $name = $page->get('search');
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM product WHERE product_id LIKE ? OR name LIKE ? OR brand LIKE ?");
    $stm->execute(["%$name%", "%$name%","%$name%"]);
    $product = $stm->fetchAll();
    
    $a = '';
    $pdo = $page->pdo();
    $stm = $pdo->query("SELECT * FROM product");
    $p = $stm->fetchAll();
?>

<?php foreach ($product as $p) {?>
<div class="product_pic">
<img src="/product/Shoes/<?=$p->product_id ?>.jpg">
</div>
<div>
    <?= $p->product_id?>
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

echo "
<a class="product" href="product.php?id=<?=$p->product_id?>">lllll</a>
";
    
<?php }?>
    

<?php 
$page->footer();
?>
