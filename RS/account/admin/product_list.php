<?php
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/admin/product_list.css'>";
$page->title = 'Product List';
$page->header();

$ids = [];
$search = "";

$s = $page->get('g', '', false);

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR 1 = ?");
$stm->execute([$s, $s == '']);
$products = $stm->fetchAll();
$stm = $pdo->query("SELECT DISTINCT category
                        FROM product
                        ORDER BY category");
$rows = $stm->fetchAll();

if ($page->is_post()) {
    //Delete
    $ids = $page->post_array('ids');
    if (count($ids) > 0) {
        $in = str_repeat('?,', count($ids)) . "0";
        $stm = $pdo->prepare("DELETE FROM product WHERE product_id IN ($in)");
        $stm->execute($ids);
        $page->temp('output', 'Record deleted');
    }
    $page->redirect("product_list.php?");
}
?>
<body>
    <section>
        <h1>
            Product List
        </h1>
        <div id='wrap'>
            <div id='category'><label>Category:</label>
                <a href="?"><button id="btn">All</button></a>
                <?php
                foreach ($rows as $row) {
                    $category = urlencode($row->category);
                    echo " <a href='?g=$category'><button id='btn'> $row->category</button></a> ";
                }
                ?>
            </div>
            <div id='check'>
                <a href="/admin/product_add.php"><button id='addProduct'>Add product</button></a>
                <button data-check="ids[]" id="chk">Check All</button>
                <button data-uncheck="ids[]" id="chk">Uncheck All</button>
                <form method="post" style="display: inline" id="f">
                    <button id="del">Delete Checked</button>
                </form>
            </div>
            <p><?= count($products) ?> record(s)</p>

            <table class="table">
                <tr>
                    <th></th>
                    <th>Product id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th></th>
                    <th></th>
                    
                </tr>
                <?php foreach ($products as $p): ?>
                    <tr data-select="id">
                        <td><input type="checkbox" name="ids[]" value="<?= $p->product_id ?>" form="f"></td>
                        <td><?= $p->product_id ?></td>
                        <td><?= $p->name ?></td>
                        <td><?= $p->price ?></td>
                        <td><?= $p->category ?></td>
                        <td><?= $p->brand ?></td>
                        <td><?= $p->size ?></td>
                        <td>
                            <a href="/admin/product_detail.php/?id=<?= $p->product_id ?>"><button>Detail</button></a>
                            <a href="/admin/product_update.php/?id=<?= $p->product_id ?>"><button>Update</button></a>
                        </td>
                        <td> 
                            <form method="post" style="display:inline" onsubmit="return confirm('Are you sure?')">
                                <input type="hidden" name="ids[]" value="<?= $p->product_id ?>">
                                <button >X</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>
</body>


<?php
$page->footer();
?>