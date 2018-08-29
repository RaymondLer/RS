<?php 
include'_config.php';

if (!$page->user) {
   
}

$order_id = $page->get('oi');
$username = $page->user->name;
var_dump($username);
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM `order` WHERE order_id = ? AND username = ?");
$stm->execute([$order_id, $username]);
$order = $stm->fetch();


$p = $pdo->query("SELECT product_id, name FROM product");
$product = $p->fetchAll();

$ss = $pdo->prepare("SELECT * FROM order_detail WHERE order_id = ? ORDER BY product_id");
$ss->execute([$order_id]);
$order_d = $ss->fetchAll();

$page->title='Product Submit';
$page->header();
?>
<body>
    <section>
        <table>
        <tr>
            <th>Date</th>
            <th>Order Id</th>
            <th>Address</th>
            <th>Total Payment</th>
        </tr>
        <tr>
            <td><?= $order->date ?></td>
            <td><?= $order->order_id ?></a></td>
            <td><?= $order->address ?></td>
            <td><?= $order->total_payment ?></td>
        </tr>
      </table>
    <table>
        <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php foreach ($order_d as $a) {?>
        <tr>
            <td><?= $a->product_id?></td>
            <td><?php foreach($product as $p){
                       if($a->product_id==$p->product_id){
                            echo $p->name;
                            break; 
                       }
                }?></td>
            <td><?= $a->quantity?></td>
            <td><?= $a->price?></td>
        </tr>
        <?php }?>
    </table>

    </section>
<?php 
$page->footer();
?>