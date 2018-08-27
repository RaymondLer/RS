<?php 
include'_config.php';

// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $id = $page->post('id');
    $quantity = $page->post('quantity');
    $cart->set($id, $quantity);
    
    $page->temp('success', 'Shopping cart updated.');
    $page->redirect();
}

// GET request -----------------------------------------------------------------
$id = $page->get('id');
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stm->execute([$id]);
$a = $stm->fetch();
$size_arr = [];
$size_arr = explode(',', $a->size);
if ($a == null) {
    $page->redirect('/'); // Redirect to "index.php"
}

$page->title='Product detail';
$page->header();
echo '<link rel="stylesheet" href="/css/product.css">';
?>

<p class="success"><?= $page->temp('success') ?></p>

<div class="wrap_aside_section">
<aside><div class="img_container">
        <img class="product_img" src="/product/Shoes/<?= $a->product_id ?>.jpg"><div id="image_div"></div>
    </div>
</aside>
<section>          
    <div class="product_brand">
        <!--<label>Brand</label>-->
        <b><?= $a->brand ?></b>
    </div>
        
    <div class="product_name">
        <!--<label>Name</label>-->
        <b><?= $a->name ?></b>
    </div>
        
    <div>
        <label>Category:</label>
        <?= $a->category ?>
    </div>
        
    <div class="product_description">
        <!--<label>Description</label>-->
        <p><?= $a->desc ?></p>
    </div>
        
    <div>
        <label>Gender:</label>
        <b><?= $a->gender ?></b>
    </div>
        
    <div class="product_price">
        <!--<label>Price</label>-->
        <b>RM <?= $a->price ?></b>
    </div>
        
    <div class="delivery">
        DELIVERED IN<br>
        Klang Valley, Johor, Penang: 1-3 days; Rest of Peninsular Malaysia: 1-4 days; Sabah, Sarawak, Brunei: 3-5 days. All in working days
    </div>
    <div id="sold_by">
        SOLD BY RS
    </div>  
</section>
    <div class="right_bar">
        <form id="product_size" method="post">
            <h3>SELECT SIZE</h3><br>
            Not Sure?  See Size Details(US size)
            <div>          
                <?php $html->select('size', $size_arr)?>
            </div>
            
            <div>
                <label>Quantity</label>
            <!-- TODO -->
                <?php $html->select('quantity', range(0, 10), $cart->get($a->id),
                                    false, 'onchange="this.form.submit()"') ?>
                <?php $html->hidden('id', $a->id) ?>
            </div>
            
            <div>
                <input type="button" href="#" id="add_cart" value="Add to Cart">    
            </div>
        </form>
    </div>
</div>

<?php 
$page->footer();
?>