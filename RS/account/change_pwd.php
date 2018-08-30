<?php
include '../_config.php';
echo '<link rel="stylesheet" href="/css/account/change_pwd.css">';
echo '<link rel="stylesheet" href="/css/header.css">';
$page->authorize('customer');

$password = $new = $confirm = '';
$err = [];

if ($page->is_post()) {
    $password = $page->post('password');
    $new = $page->post('new');
    $confirm = $page->post('confirm');

    if ($password == '') {
        $err['password'] = 'Password is required.';
    }

    if ($new == '') {
        $err['new'] = 'New Password is required.';
    } else if (strlen($new) < 5) {
        $err['new'] = 'New Password must more than 5 characters.';
    } else if (!preg_match('/^\S+$/', $new)) {
        $err['new'] = 'New Password should not contain spaces.';
    }

    if ($confirm == '') {
        $err['confirm'] = 'Confirm Password is required.';
    } else if ($confirm != $new) {
        $err['confirm'] = 'Confirm Password and New Password not matched.';
    }

    if (!$err) {
        $pdo = $page->pdo();
        $stm = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stm->execute([$page->user->name]);
        $user = $stm->fetch();

        if ($user != null && password_verify($password, $user->hash)) {
            $table = $user->role;
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stm = $pdo->prepare("UPDATE $table SET hash = ? WHERE username = ?");
            $stm->execute([$hash, $page->user->name]);

            $page->temp('success', 'Password changed.');
            $page->redirect();
        } else {
            $err['password'] = 'Password not matched.';
        }
    }
}

$page->title = 'Change Password';
$page->header();
?>

<body>
    <p class="success"><?= $page->temp('success') ?></p>
    <section>
        <form method="post">
            <div class="form">
                <h2>Change Password</h2>
                <div class="change">
                    <label for="password">Password :</label>
                    <?php $html->password('password', $password) ?>
                    <?php $html->error($err, 'password') ?>
                </div>

                <div class="change">
                    <label for="new">New Password :</label>
                    <?php $html->password('new', $new) ?>
                    <?php $html->error($err, 'new') ?>
                </div>

                <div class="change">
                    <label for="confirm">Confirm Password :</label>
                    <?php $html->password('confirm', $confirm) ?>
                    <?php $html->error($err, 'confirm') ?>
                </div>

            </div>

            <div style="text-align: center;">
                <button class="btn">Change Password</button>
                <button type="reset" class="btn">Reset</button>
            </div>
        </form>
    </section>
</body>

<?php
$html->focus('password', $err);
$page->footer();
?>

