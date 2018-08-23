<?php 
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

// post the product 
if($page->is_post()){
    
}

//Maybe get the product name to compare the product name is crash

$pdo = $page->pdo();
$s = $pdo->query("SELECT * FROM product");

$name = "";
$desc = "";
$brand = "";
$size = "";
$price = "";
$dcategory = [];
$category = [];
foreach($s as $s){
    $dcategory[] = $s->category;
}


?>
<body>
    <section>
        <form method="post" action="#" >
            <h1>Product detail</h1>
            <div class="input-group">
                <label>Product name:</label>
                <?php $html->text('product_name',$name,50)?>
            </div>
            <div class="input-group">
                <label>Description:</label>
                <?php $html->text('description',$desc,200)?>
            </div>
                <div class="input-group">
                <label>Brand:</label>
            <?php $html->text('brand',$brand,20)?>
            </div>
            
            <div class="input-group">
                <label>Size Available:</label>
                <?php $html->text('size',$size,50)?>
            </div>
            <div class="input-group">
                <label>Category:</label>
                <?php $html->select('category',$dcategory,$category)?>
                If got other:
                <?php $html->text('category',$category);?>
            </div>
            <div class="input-group">
                <label>Image :</label>
                
            <!--The upload the pic-->
                <input type="text" name="image_url">
            </div>
            <div class="input-group">
                <label>Price:</label>
                <?php $html->text('price',$price)?>
            </div>
            <div id='coverB'>
                <div class="buttons">
                    <button tpe="submit" name="submit" class="btn">Submit</button>
                    <button type="reset" name="reset" class='btn'>Reset</button>
                </div>
            </div>
        </form>
    </section>
</body>

<?php 
$page->footer();
?>