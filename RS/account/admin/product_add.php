<?php 
//include('../database.php');
include'../../_config.php';
$page->authorize('admin');
echo "<link rel='stylesheet' href='/css/admin/product_add.css'>";
$page->title='Add Product';
$page->header();

$pdo = $page->pdo();
$product_id =$name = $desc = $brand = $size = $price = $category = $gender = $g = $quantity = "";
$dcategory = ['Other'];
$arr_gender = [
    'F' => 'Female',
    'M' => 'Male',
    'B' => 'Both',
    'O' => 'Other',
];

function validateFile($file) {
    global $err;
        if ($file['error'] == UPLOAD_ERR_NO_FILE) {
         $err['file'] = 'Photo is required.';
     }
     else if ($file['error'] == UPLOAD_ERR_FORM_SIZE ||
         $file['error'] == UPLOAD_ERR_INI_SIZE) {
         $err['file'] = 'Photo exceeds size allowed.';
     }
     else if ($file['error'] != UPLOAD_ERR_OK) {
         $err['file'] = 'Photo failed to upload.';
     }
     else {
         $mime = mime_content_type($file['tmp_name']);
         var_dump($mime);
         var_dump($file['tmp_name']);
         if ($mime != 'image/jpeg' && $mime != 'image/png') {
             $err['file'] = 'Only JPEG or PNG photo allowed.';
         }
    }
}
//Compare the id with the database
$s = $pdo->query("SELECT product_id FROM product");
$product_id = 1001;
$try = false;
do{
    foreach($s as $s){
        if($product_id != $s->product_id){
            $try=true;
            break;
        }
        $product_id ++;
    }
}while(!$try);
//Display the category of the shoes
$cate = $pdo->query("SELECT DISTINCT category FROM product ");
foreach($cate as $s){
    $dcategory[] = $s->category;    
}
$err = [];
// post the product 
if($page->is_post()){
    $name = $page->post('product_name');
    $desc = $page->post('description');
    $brand = $page->post('brand');
    $size = $page->post('size');
    $quantity = $page->post('quantity');
    if($page->post('sCategory')==0){
        $category = $page->post('category');
    }
    else {
        $category = $page->post('sCategory');
        $category = $dcategory[$category];
    }
    $price = $page->post('price');
    $g = $page->post("gender");
    if($g!="")
        $gender = $arr_gender[$g];
    //Validation
    if($name == ""){
        $err['name'] = 'Product name is required.';
    }
    if(!strlen(trim($desc))){
         $err['description'] = 'Description is required.';
    }
    if($brand == ""){
        $err['brand'] = 'Brand is required.';
    }
    if($quantity == ""){
        $err['quantity'] = 'Quantity is required.';
    }
    $pattern = "/[^\d,]+$/";
    if($size == ""){
        $err['size'] = 'Size is required.';
    }else if(preg_match($pattern, $size)){
        $err['size'] = 'Please type the right format';
    }
    if($category == 0 && $category==""){
        $err['category'] = 'Category is required';
    }
    if($price == ""){
        $err['price'] = 'Price is required.';
    }else if($price == 0){
         $err['price'] = 'Price cannot be zero.';
    }
    if($gender == ""){
        $err['gender'] = 'Gender is required.';
    }
    $file = $_FILES['file'];
    validateFile($file);
    
    if (!$err) {
        $iName = $product_id. '.jpg';

        include '../../include/simpleImage.php';
        $img = new SimpleImage();
        $img->fromFile($file['tmp_name'])
            ->toFile("../../post_product/$iName", "image/jpeg", 80);
            
        $stm = $pdo->prepare("
        INSERT INTO product (product_id,name,price,`desc`,gender,category,brand,size,quantity)
        VALUES (?,?, ?, ?, ?, ?, ?, ?,?)
    ");
    $stm->execute([$product_id,$name,$price,$desc,$gender,$category,$brand,$size, $quantity]);
    $page->temp('success', 'Product is inserted');
//    $page->redirect("/account/admin/product_add.php");

    }
}
?>
<body>
    <section>
        <p class="success"><?= $page->temp('success') ?></p>
        <form method="post" enctype="multipart/form-data">
            <h1>Add Product</h1>
             <?php $html->hidden('product_id',$product_id)?>
            <div class="input-group">
                <label>Product name:</label>
                <?php $html->text('product_name',$name,50)?>
                <?php $html->error($err, 'name') ?>
            </div>
            <div class="input-group">
                <label>Description:</label>
                <?php $html->textArea('description',$desc,50,6,'style="resize:none;"')?>
                <?php $html->error($err, 'description') ?>
            </div>
                <div class="input-group">
                <label>Brand:</label>
            <?php $html->text('brand',$brand,20)?>
                <?php $html->error($err, 'brand') ?>
            </div>
            
            <div class="input-group">
                <label>Size Available:</label>
                <?php $html->text('size',$size,50,'placeholder="21,22,23"')?>
                <?php $html->error($err, 'size') ?>
            </div>
            <div class="input-group">
                <label>Category:</label>
                <?php $html->select('sCategory',$dcategory,"",false)?>
                If got other:
                <?php $html->text('category',$category);?>
                <?php $html->error($err, 'category') ?>
            </div>
             <div class="gender">
                <label>Gender:</label>
                 <span id="gender"><?php $html->radio_list('gender', $arr_gender,$g) ?>
                <?php $html->error($err, 'gender') ?></span>
            </div>
            <div class="input-group">
                <label>Image :</label>
                <input type="file" id="file" name="file" accept="image/*">
                <?php $html->error($err, 'file') ?></span>
            </div>
            <div class="input-group">
                <label>Quantity Available:</label>
                <?php $html->text('quantity',$quantity)?>
                <?php $html->error($err, 'quantity') ?>
            </div>
            <div class="input-group">
                <label>Price(RM):</label>
                <?php $html->text('price',$price)?>
                <?php $html->error($err, 'price') ?>
            </div>
            <div id='coverB'>
                <label></label>
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