<?php 
include'../_config.php';
$page->title='Update Product';
$page->header();
    
$pdo = $page->pdo();
$product_id ="";
$name = "";
$desc = "";
$brand = "";
$size = "";
$price = "";
$dcategory = ['Other'];
$category = "";
$gender = "";
$arr_gender = [
    'F' => 'Female',
    'M' => 'Male',
    'B' => 'Both',
    'O' => 'Other',
];
//GET
function validateFile($err, $file) {
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
         // NOTE: Remember to enable "fileinfo" extension in "php.ini"
         $mime = mime_content_type($file['tmp_name']);
         if ($mime != 'image/jpeg' && $mime != 'image/png') {
             $err['file'] = 'Only JPEG or PNG photo allowed.';
         }
    }
}
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
    if($page->post('sCategory')==0){
        $category = $page->post('category');
    }
    else {
        $category = $page->post('sCategory');
        $category = $dcategory[$category];
    }
    $price = $page->post('price');
    $gender = $page->post("gender");
    //Validation
    if($name == ""){
        $err['name'] = 'Product name is required.';
    }
    if(!strlen(trim($desc))){
         $err['description'] = 'Description is required.';
    }
    if($brand == ""){
        $err['brand'] = 'brand is required.';
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
    validateFile($err, $file);
    
    if (!$err) {
        $iName = $product_id. '.jpg';

        include '../include/simpleImage.php';
        $img = new SimpleImage();
        $img->fromFile($file['tmp_name'])
            ->toFile("../post_product/$iName", "image/jpeg", 80);
            
        $stm = $pdo->prepare("
        INSERT INTO product (product_id,name,price,`desc`,gender,category,brand,size)
        VALUES (?,?, ?, ?, ?, ?, ?, ?)
    ");
    $stm->execute([$product_id,$name,$price,$desc,$gender,$category,$brand,$size]);
    $page->temp('output', 'Product is inserted');

     }
}
    
$d = $page->get('id');
    
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stm->execute([$d]);
$p = $stm->fetch();
    
?>
<body>
    <section>
        <div>
            <label>Product id:</label>
            <?= $p->product_id;?>
        </div>
        <div class="input-group">
            <label>Product name:</label>
            <?php $html->text('product_name',$p->name,50)?>
            <?php $html->error($err, 'name') ?>
        </div>
        <div class="input-group">
            <label>Description:</label>
            <?php $html->textArea('description',$p->desc,50,4)?>
            <?php $html->error($err, 'description') ?>
        </div>
            <div class="input-group">
            <label>Brand:</label>
        <?php $html->text('brand',$p->brand,20)?>
            <?php $html->error($err, 'brand') ?>
        </div>

        <div class="input-group">
            <label>Size Available:[If got more put (23,24)]</label>
            <?php $html->text('size',$p->size,50)?>
            <?php $html->error($err, 'size') ?>
        </div>
        <div class="input-group">
            <label>Category:</label>
            <?php $html->select('sCategory',$dcategory,"",false)?>
            If got other:
            <?php $html->text('category',$p->category);?>
            <?php $html->error($err, 'category') ?>
        </div>
         <div class="gender">
            <label>Gender:</label>
            <span id="gender"><?php $html->radio_list('gender', $arr_gender,$p->gender) ?>
            <?php $html->error($err, 'gender') ?></span>
        </div>
        <div class="input-group">
            <label>Image :</label>
            <input type="file" id="file" name="file" accept="image/*">
        </div>
        <div class="input-group">
            <label>Price:</label>
            <?php $html->text('price',$p->price)?>
            <?php $html->error($err, 'price') ?>
        </div>
        <div>
            image
        </div>
        <div id='coverB'>
            <div class="buttons">
                <button tpe="submit" name="submit" class="btn">Submit</button>
                <button type="reset" name="reset" class='btn'>Reset</button>
            </div>
        </div>
        
    </section>
</body>
   



<?php 
$page->footer();
?>