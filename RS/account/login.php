<?php
include'../_config.php';

$username = $password = '';
$err = [];

if ($page->is_post()) {
    $username = $page->post('username');
    $password = $page->post('password');
    
    if ($username == '') {
        $err['username'] = 'Username is required.';
    }
    
    if ($password == '') {
        $err['password'] = 'Password is required.';
    }
    
    if (!$err) {
        $pdo = $page->pdo();
        $stm = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stm->execute([$username]);
        $user = $stm->fetch();
        
        if ($user != null && password_verify($password, $user->hash)) {
            $page->sign_in($user->username, $user->role);   
        }
        else {
            $err['password'] = 'Username and Password not matched.';
        }
    }
}

$page->title = 'Login';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<form method="post">
    <div class="form">
        <h1>Login</h1>
        <fieldset>
            <div>
                <label for="username">Username</label>
                <?php $html->text('username', $username) ?>
                <?php $html->error($err, 'username') ?>
            </div>

            <div>
                <label for="password">Password</label>
                <?php $html->password('password', $password) ?>
                <?php $html->error($err, 'password') ?>
            </div>

            <div>
                <span class="pwd"><a href="recovery_password.php">Forget Password?</a></span>
            </div>
        </fieldset>
    </div>
    
    <button>Login</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('username', $err);
$page->footer();
?>