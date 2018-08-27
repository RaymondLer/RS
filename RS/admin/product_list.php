<?php 
//include('../database.php');
include'../_config.php';
$page->title='Product Submit';
$page->header();

$ids = [];
$search = "";

$s = $page->get('g','',false);

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR 1 = ?");
$stm->execute([$s, $s == '']);
$products = $stm->fetchAll();
$stm = $pdo->query("SELECT DISTINCT category
                        FROM product
                        ORDER BY category");
$rows = $stm->fetchAll();

if($page->is_post()){
    //Delete
        $ids = $page->post_array('ids');
        if(count($ids) > 0){
        $in = str_repeat('?,',count($ids)) . "0";
        $stm = $pdo->prepare("DELETE FROM product WHERE product_id IN ($in)");
        $stm->execute($ids);
        $page->temp('output','Record deleted');
        }
        $page->redirect("product_list.php?");
    }
?>
<body>
    <section>
        <div>
            <a href="?">All</a>
            <?php
            foreach ($rows as $row) {
                $category = urlencode($row->category);
//                $category = str_replace(' ', '+', $row->category);
                echo " | <a href='?g=$category'> $row->category</a> ";
            }
            ?>
        </div>
        <a href="/admin/product_sell.php">Add product</a>
        <div>
        <button data-check="ids[]">Check All</button>
            <button data-uncheck="ids[]">Uncheck All</button>
            <form method="post" style="display: inline" id="f">
            <button>Delete Checked</button>
            </form>
        </div>
        <p><?= count($products) ?> record(s)</p>

        <table class="table">
            <tr>
                <th></th>
                <th>Product id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Gender</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Size</th>
            </tr>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?= $p->product_id ?>" form="f"></td>
                <td><a href = "/admin/product_detail.php?id=<?= $p->product_id  ?>" name="ids[]" value="<?= $p->product_id   ?>"><?=$p->product_id?></a></td>
                <td><?= $p->name        ?></td>
                <td><?= $p->price       ?></td>
                <td><?= $p->desc        ?></td>
                <td><?= $p->gender      ?></td>
                <td><?= $p->category    ?></td>
                <td><?= $p->brand       ?></td>
                <td><?= $p->size        ?></td>
                <td>
                    <a href="/admin/product_detail.php/?id=<?= $p->product_id?>">Update</a>
                </td>
                <td> 
                    <form method="post" style="display:inline" onsubmit="return confirm('Are you sure?')">
                    <input type="hidden" name="ids[]" value="<?= $p->product_id   ?>">
                    <button >X</button>
                    </form>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>


<?php 
$page->footer();
?>