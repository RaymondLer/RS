<?php 
include'../_config.php';
$page->title='Update Product';
$page->header();
    
$pdo = $page->pdo();
$product_id =$name = $desc = $brand = $size = $price = $category = $gender = "";
$dcategory = ['Other'];
$arr_gender = [
    'F' => 'Female',
    'M' => 'Male',
    'B' => 'Both',
    'O' => 'Other',
];
//GET
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
    $product_id = $page->post('product_id');
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
    $file = $_FILES['file'];
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
    if ($file['name']) {
        if ($file['error'] == UPLOAD_ERR_FORM_SIZE ||
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

    validateFile($file);
    var_dump($product_id);
    if (!$err) {
        if($file['name']){
            $iName = $product_id. '.jpg';
            unlink("../post_product/$iName");
            include '../include/simpleImage.php';
            $img = new SimpleImage();
            $img->fromFile($file['tmp_name'])
                ->toFile("../post_product/$iName", 'image/jpeg');
        }
        $stm = $pdo->prepare("
        UPDATE product SET name = ?, price = ?, `desc` = ?, gender = ?, category = ?, brand = ?, size = ? WHERE product_id = ?
    ");
    $stm->execute([$name,$price,$desc,$gender,$category,$brand,$size,$product_id]);
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
        <form method="post" enctype="multipart/form-data">
        <div>
            <label>Product id:</label>
            <?= $p->product_id;?>
            <?php $product_id= $p->product_id;
            $html->hidden('product_id',$product_id)?>
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
            <?php 
            $key_cate = array_search($p->category, $dcategory);?>
            <?php $html->select('sCategory',$dcategory,$key_cate,false)?>
            If got other:
            <?php $html->text('category');?>
            <?php $html->error($err, 'category') ?>
        </div>
         <div class="gender">
            <label>Gender:</label>
           <?php $key = array_search($p->gender, $arr_gender);?>
            <span id="gender"><?php $html->radio_list('gender', $arr_gender,$key) ?>
                
            <?php $html->error($err, 'gender') ?></span>
        </div>
        <div class="input-group">
            <label for='file'>Image :</label><label>
            <input type="file" id="file" name="file" accept="image/*" style="display: none">
            <img id="prev" src="../post_product/<?= $p->product_id?>.jpg">
            </label>
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
        </form>
    </section>
</body>
   
<script>
    var img = $("#prev")[0];
    var src = img.src;
    
    img.onerror = function (e) {
        img.src = src;
        $("#file").val("");
    };    
    $("#file").change(function (e) {
        var f = this.files[0];
        img.src = URL.createObjectURL(f);
    });
</script>


<?php 
$page->footer();
?>