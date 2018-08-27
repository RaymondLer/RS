<?php

include'_config.php';

if ($page->is_post()) {
    $product_id = $page->post('product_id');
    $quantity = $page->post('quantity');
    $cart->set($product_id, $quantity);
    
    $page->temp('success', 'Shopping cart updated.');
    $page->redirect();
}
$product = "";
$pdo = $page->pdo();
$stm = $pdo->query("SELECT * FROM product");
$a = $stm->fetchAll();


$page->title = 'Main';
$page->header();
echo '<link rel="stylesheet" href="/css/main.css">';

?>
<body>
        
        <div class="wrap">
            <div id="aside">
                <h2>Brands</h2>
                <ul><li><a href="#">Adidas</a></li>
                    <li><a href="#">Nike</a></li>
                </ul>
            </div>
            <div id="section">
                <?php foreach ($a as $a) {?>
                <a href="#"><form id="product">
                        
                    <div class="product_pic">
                        
                        <img src="/product/Shoes/<?=$a->product_id ?>.jpg">
                    </div>
                        <div id="container_name_price">
                    <div class="product_name">
                        <?= $a->name?>
                    </div>
                        <div class="product_price">
                       <?= $a->price ?>
                    </div>
                        </div>
                    <div class="product_description">
                        <?= $a->desc ?>
                    </div>
                    
                    </form>
                </a>
                <?php }?>
                
                
                
                    
            </div>
            </div>
 <?php
 $page->footer();
 ?>