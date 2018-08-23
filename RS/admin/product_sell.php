<?php 
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

$pdo = $page->pdo();
$name = "";
$desc = "";
$brand = "";
$size = "";
$price = 0;
$dcategory = [];
$category = "";
$gender = "";

$pdo = $page->pdo();
$s = $pdo->query("SELECT * FROM product");
foreach($s as $s){
    $dcategory[] = $s->category;
}
// post the product 
if($page->is_post()){
    $name = $page->post('product_name');
    $desc = $page->post('description');
    $brand = $page->post('brand');
    $size = $page->post('size');
    if(!$category){
        $category = $page->post('sCategory');
    }
    else{
        $category = $page->post('category');
    }
    $price = $page->post('price');
    $gender = $page->post("gender");
    

    $stm = $pdo->prepare("
        INSERT INTO product (name,price,`desc`,gender,category,brand,size)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stm->execute([$name,$price,$desc,$gender,$category,$brand,$size]);
}

//Maybe get the product name to compare the product name is crash






?>
<body>
    <section>
        <form method="post" action="/admin/product_sell.php" >
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
                <?php $html->select('sCategory',$dcategory,$category)?>
                Got other?
                If got other:
                <?php $html->text('category',$category);?>
            </div>
             <div class="input-group">
                <label>Gender:</label>
                <?php $html->text('gender',$gender)?>
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