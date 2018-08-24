<?php 
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

$pdo = $page->pdo();
$product_id = rand(1, 9999);
$name = "";
$desc = "";
$brand = "";
$size = "";
$price = 0;
$dcategory = [];
$category = "";
$gender = "";
$arr_gender = [
    'F' => 'Female',
    'M' => 'Male'
];
$err = [];
function validateFile($err, $file) {
        if ($file['error'] == UPLOAD_ERR_NO_FILE) {
            $err['file'] = 'No file selected.';
        }
        else if ($file['error'] == UPLOAD_ERR_INI_SIZE ||
                 $file['error'] == UPLOAD_ERR_FORM_SIZE) {
            $err['file'] = 'File exceeds the size allowed.';
        }
        else if ($file['error'] != UPLOAD_ERR_OK) {
            $err['file'] = 'System error. Failed to upload file.';
        }
        else {
            // TODO:
            $mime = mime_content_type($file['tmp_name']);
            if ($mime != 'image/jpeg' && $mime != 'image/png') {
                $err['file'] = 'Only JPEG or PNG is allowed.';
            }
        }
    }
$pdo = $page->pdo();
$s = $pdo->query("SELECT * FROM product");
do{
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
    
    $file = $_FILES['file'];
        
    validateFile($err, $file);
    if (!$err) {
        //$name = basename($file['name']);
        //move_uploaded_file($file['tmp_name'], "../photo/$name");

        $iName = $product_id.'.jpg';

        include '../include/simpleImage.php';
        $img = new SimpleImage();
        $img->fromFile($file['tmp_name'])
            ->toFile("../post_product/$product_id", "image/jpeg", 80);
            
        $stm = $pdo->prepare("
        INSERT INTO product (name,price,`desc`,gender,category,brand,size)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stm->execute([$name,$price,$desc,$gender,$category,$brand,$size]);
//  $page->temp('output', 'Record inserted.');
    $page->redirect('/admin/product_sell.php');
     }
    
}

//Maybe get the product name to compare the product name is crash






?>
<body>
    <section>
        <form method="post">
            <h1>Product detail</h1>
            <div class="input-group">
                <label>Product name:</label>
                <?php $html->text('product_name',$name,50)?>
            </div>
            <div class="input-group">
                <label>Description:</label>
                <?php $html->textArea('description',50,4)?>
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
                <?php $html->radio_list('gender', $arr_gender) ?>
            </div>
            <div class="input-group">
                <label>Image :</label>
                 <input type="file" id="file" name="file"
                       accept="image/*" style="display: none">
                Click to select photo...
                <img id="prev" src="/image/no-photo.png">
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