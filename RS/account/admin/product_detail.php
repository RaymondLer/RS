<?php
include'../_config.php';
echo "<link rel='stylesheet' href='/css/admin/product_detail.css'>";
$page->title = 'Product Details';
$page->header();

    $d = $page->get('id');
    if ($d == "") {
        $page->redirect("product_list.php");
    }
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
    $stm->execute([$d]);
    $p = $stm->fetch();

?>
<body>
    <h1>Product Detail </h1>
    <div id='wrap'>
        <aside>
            <div class='image'>
                <img src="/post_product/<?= $p->product_id ?>.jpg" style="width:300px;height:300px;">
            </div>
        </aside>
        <section>
            <table>
                 <tr>
                    <th>
                        Product id:
                    </th>
                    <td>
                        <?php echo $p->product_id; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Name
                    </th>
                    <td>
                        <?php echo $p->name; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Price:
                    </th>
                    <td>
                        <?php echo $p->price; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Description:
                    </th>
                    <td>
                        <?php echo $p->desc; ?>
                    </td>
                </tr> <tr>
                    <th>
                        Gender:
                    </th>
                    <td>
                        <?php echo $p->gender; ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Category:
                    </th>
                    <td>
                        <?php echo $p->category; ?>
                    </td>
                </tr> 
                <tr>
                    <th>
                        Brand:
                    </th>
                    <td>
                        <?php echo $p->brand; ?>
                    </td>
                </tr> 
                <tr>
                    <th>
                        Size:
                    </th>
                    <td>
                        <?php echo $p->size; ?>
                    </td>
                </tr>
            </table>
            <a href="/admin/product_list.php"><button id="back">back</button></a>
        </section>
    </div>
</body>




<?php
$page->footer();
?>