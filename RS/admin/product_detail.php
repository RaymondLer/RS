<?php 
    include'../_config.php';
    echo "<link rel='stylesheet' href='/css/product_sell.css'>";
    $page->title='Product Submit';
    $page->header();
    
$d = $page->get('id');
    
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stm->execute([$d]);
$p = $stm->fetch();
?>
<body>
    <aside>
        Picture
    </aside>
    <section>
        <div>Product id:
        <?php echo $p->product_id;?>
        </div>
        <div>Name
        <?php echo $p->name;?>
        <div>Price
        <?php echo $p->price;?></div>
        <div>Description
        <?php echo $p->desc;?></div>
        <div>Gender
        <?php echo $p->gender;?></div>
        <div>Category
        <?php echo $p->category;?></div>
        <div>Brand
        <?php echo $p->brand;?></div>
        <div>Size
        <?php echo $p->size;?></div>
        <?php 
        $arr = [];
        $arr = explode(',',$p->size);
        var_dump($arr)?>
    </section>
</body>
   



<?php 
$page->footer();
?>