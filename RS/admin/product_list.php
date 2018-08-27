<?php 
//include('../database.php');
include'../_config.php';
$page->title='Product Submit';
$page->header();

$ids = [];
$search = "";
$s = $page->get('g');
echo utf8_decode(urldecode("Ant%20B4nio+Carlos+Jobim"));
echo utf8_decode(urldecode($s));

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR 1 = ?");
$stm->execute([$s, $s == '']);
$products = $stm->fetchAll();
$stm = $pdo->query("SELECT DISTINCT category
                        FROM product
                        ORDER BY category");
$rows = $stm->fetchAll();

if($page->is_post()){
        $ids = $page->post_array('ids');
        if(count($ids) > 0){
        $in = str_repeat('?,',count($ids)) . "0";
        $stm = $pdo->prepare("DELETE FROM product WHERE product_id IN ($in)");
        $stm->execute($ids);
        $page->temp('output','Record deleted');
        }
        $page->redirect("product_list.php");
    }
?>
<body>
    <section>
        <div>
            <a href="?">All</a>
            <?php
            foreach ($rows as $row) {
                echo " | <a href='?g=$row->category'> $row->category</a> ";
            }
            ?>
        </div>
        <button data-check="ids[]">Check All</button>
            <button data-uncheck="ids[]">Uncheck All</button>
            <form method="post" style="display: inline" id="f">
            <button>Delete Checked</button>
        </form>
        <!--Search the things from category, id,name,description,brand-->
        <div>
            <?php $html->text('search',$search)?>
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
                <td><input type="checkbox" name="ids[]" value="<?= $p->$product_id ?>" form="f"></td>
                <td><?= $p->product_id  ?></td>
                <td><?= $p->name        ?></td>
                <td><?= $p->price       ?></td>
                <td><?= $p->desc        ?></td>
                <td><?= $p->gender      ?></td>
                <td><?= $p->category    ?></td>
                <td><?= $p->brand       ?></td>
                <td><?= $p->size        ?></td>
                <td> 
                    <form method="post" style="display:inline" onsubmit="return confirm('Are you sure?')">
                    <input type="hidden" name="ids[]" value="<?= $p->product_id   ?>">
                    <button >Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>
<script>
    $(function() {
    
    // Reload page
    $("[type=reset]").click(function (e) {
        e.preventDefault();
        location = location;
    });
   

    $("[data-check]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("check");
        $(`[name="${name}"]`).prop("checked", true);
    });
   
    // Uncheck all checkboxes
    $("[data-uncheck]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("uncheck");
        $(`[name="${name}"]`).prop("checked", false);
    });
});
</script>

<?php 
$page->footer();
?>