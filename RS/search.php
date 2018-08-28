<?php 
include '_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

    $name = $page->get('search');
    if($page->get('search')== ''){
        $page->temp('warning','The thing you search in not found');
        $page->redirect('main.php');
    }
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM product WHERE product_id LIKE ? OR name LIKE ? OR brand LIKE ? OR category LIKE ?");
    $stm->execute(["%$name%", "%$name%","%$name%","%$name%"]);
    $product = $stm->fetchAll();
    if($product==null){
        $html->warning("The thing search for is not found");
        $page->redirect('main.php');
    }
    $a = '';
    $pdo = $page->pdo();
    $stm = $pdo->query("SELECT * FROM product");
    $p = $stm->fetchAll();
    
?>

<?php foreach ($product as $p) {?>
<div class="product_pic">
    <img src="/post_product/<?=$p->product_id ?>.jpg">
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
