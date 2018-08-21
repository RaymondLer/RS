<?php
$product_name='';
$description='';
$category='';
$image_url='';
$price='';

$db=mysqli_connect('localhost','root','','');

if (isset($_POST['save'])){
    $product_name=$_POST['product_name'];
    $description=$_POST['description'];
    $category=$_POST['category'];
    $image_url=$_POST['image_url'];
    $price=$_POST['price'];
    
    $query="INSERT INTO product(product_name,description,category,image_url,price) VALUE ('$prduct_name','$description','$category','$image_url','$price')";
    mysqli_query($db,$query);
    header('location:product_sell.php'); 
}
if($page->is_post()){
    $product_name = $page->post('product_name');
    $description = $page->post('description');
    $category = $page->post('category');
    $image = $page->post('image');
    $price = $price->post('price');
    
    $pdo = $page->pdo();
    $stm = $pdo->prepare("INSERT table(product_id,product_name,description,category,image,price) VALUES (?,?,?,?,?,?)");
    $stm->execute([$product_id,$product_name,$description,$category,$image,$price]);
    $err = [];
    
//    Update the product
//    $stm = $pdo->prepare("UPDATE table SET product_name=?, description = ?, category = ?, image = ?, price = ?");
//    $stm->execute([$product_id,$product_name,$description,$category,$image,$price]);

//
//
    
}
    
//    public function post_array($name, $default = [], $escape = true, $trim = true) {
//        $items = isset($_POST[$name]) ? $_POST[$name] : $default;
//        
//        foreach ($items as $value) {
//            if ($escape) $value = htmlspecialchars($value);
//            if ($trim)   $value = trim($value);
//        }
//        
//        return $items;
//    }
//    
//    public function is_get() {
//        return $_SERVER['REQUEST_METHOD'] == 'GET';
//    }
//    
//    public function is_post() {
//        return $_SERVER['REQUEST_METHOD'] == 'POST';
//    }
//    
//    public function redirect($url) {
//        ob_clean();
//        header("Location: $url");
//        exit();
//    }Add into the config


?>