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
        <?php echo $html->hidden('id',$p->product_id);?>
        </div>
        <div>Name
        <?php echo $html->hidden('id',$p->product_id);?>
        <div>Price
        <?php echo $html->hidden('id',$p->product_id);?></div>
        <div>Description
        <?php echo $html->hidden('id',$p->product_id);?></div>
        <div>Gender
        <?php echo $html->hidden('id',$p->product_id);?></div>
        <div>Category
        <?php echo $html->hidden('id',$p->product_id);?></div>
        <div>Brand
        <?php echo $html->hidden('id',$p->product_id);?></div>
        <div>Size
        <?php echo $html->hidden('id',$p->product_id);?></div>
        
    </section>
</body>
   



<?php 
$page->footer();
?>