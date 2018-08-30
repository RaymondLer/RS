<?php
include'_config.php';
echo "<link rel='stylesheet' href='/css/footer.css'>";

if ($page->is_post()) {
    $sql = file_get_contents('product.sql');
    $pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
    $pdo->exec($sql);

    $page->temp('success', 'Database restored.');
}
$page->title = 'Registration';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<p>Start MySQL and click the <b>Restore Database</b> button.<p>

<form method="post">
    <button>Restore Database</button>
</form>

<?php
$page->footer();
?>