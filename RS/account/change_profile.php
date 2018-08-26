<?php
include '../_config.php';
//$page->authorize('customer');

$err = [];
$pdo = $page->pdo();

if ($page->is_post()) {
    $name  = $page->post('name');
    $email = $page->post('email');
    $phone = $page->post('phone');
        
    if ($name == '') {
        $err['name'] = 'Name is required.';
    }
    else if (strlen($name) > 100) {
        $err['name'] = 'Name must not more than 100 characters.';
    }
    
    if ($email == '') {
        $err['email'] = 'Email is required.';
    }
    else if (strlen($email) > 100) {
        $err['email'] = 'Email must not more than 100 characters.';
    }
    else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $err['email'] = 'Email format invalid.';
    }
    
    if ($phone == '') {
        $err['phone'] = 'Phone is required.';
    }
    else if (!preg_match('/^01\d-\d{7,8}$/', $phone)) {
        $err['phone'] = 'Phone format invalid.';
    }
    
    if (!$err) {
        // TODO: Update member record
        
        // (2) Update member record
        $stm = $pdo->prepare("
            UPDATE customer
            SET name = ?, email = ?, phone = ?
            WHERE username = ?
        ");
        $stm->execute([$name, $email, $phone, $page->user->name]);
        
        $page->temp('success', 'Profile changed.');
        $page->redirect();
    }
}

// GET request (select) --------------------------------------------------------
if ($page->is_get()) {
    // TODO: Select member record
    $stm = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
    $stm->execute([$page->user->name]);
    $m = $stm->fetch();
            
    $name  = $m->name;
    $email = $m->email;
    $phone = $m->phone; 
}

$page->title = 'Change Profile';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<form method="post" enctype="multipart/form-data">
    <div class="form">
        <div>
            <label for="username">Username</label>
            <!-- TODO: Username -->
            <b><?= $page->user->name ?></b>
        </div>
        <div>
            <label for="name">Name</label>
            <?php $html->text('name', $name, 100) ?>
            <?php $html->error($err, 'name') ?>
        </div>
        <div>
            <label for="email">Email</label>
            <?php $html->text('email', $email, 100) ?>
            <?php $html->error($err, 'email') ?>
        </div>
        <div>
            <label for="phone">Phone</label>
            <?php $html->text('phone', $phone, 12) ?>
            <?php $html->error($err, 'phone') ?>
        </div>
    </div>
    
    <button>Change Profile</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('name', $err);
$page->footer();
?>