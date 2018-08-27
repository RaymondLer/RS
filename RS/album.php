<?php

include'_config.php';
$page->title = 'Main';
$page->header();
echo '<link rel="stylesheet" href="/css/main.css">';


$b = $page->get('b');
$c = $page->get('c');
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product
                      WHERE brand = ? OR 1 = ? AND category = ? OR 1=?");

$stm->execute([$b, $b == '',$c,$c == '']);
$product = $stm->fetchAll();

$stm = $pdo->query("SELECT DISTINCT brand
                    FROM product
                    ORDER BY brand");
$rows = $stm->fetchAll();
$stm = $pdo->query("SELECT DISTINCT category
                    FROM product
                    ORDER BY category");
$category = $stm->fetchAll();
?>
<body>
        
        <div class="wrap">
            <div id="aside">
                <h2>Brands</h2>
                <ul>
                    <?php
                    foreach ($rows as $row):?>
                    <li>
                        <a href='?b=<?=$row->brand;?> '> <?=$row->brand;?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
                <h2>Category</h2>
                <ul>
                    <?php
                    foreach ($category as $row):?>
                    <li>
                        <a href='?c=<?=$row->category;?> '> <?=$row->category;?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div id="section">
                <?php foreach ($product as $a) {?>
                <a href="#"><form id="product">
                        
                    <div class="product_pic">
                        
                        <img src="/product/Shoes/<?=$a->product_id ?>.jpg">
                    </div>
                        <div id="container_name_price">
                    <div class="product_name">
                        <?= $a->name?>
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
                <?php }?>
                
                
                
                    
            </div>
            </div>
 <?php
 $page->footer();
 ?>