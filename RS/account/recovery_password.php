<?php
include '../_config.php';
//$page->authorize('customer');

$email = '';
$err = [];

if ($page->is_post()) {
    $email    = $page->post('email');
    
    if ($email == '') {
        $err['email'] = 'Email is required.';
    }
    else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $err['email'] = 'Email format invalid.';
    }
    
    if (!$err) {
        // Reset password (update database and send email)
        $pdo = $page->pdo();
        
        // (1) Verify if username and email matched
        $stm = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stm->execute([$email]);
        $user = $stm->fetch();
        $username = $user->username;
        if ($user) {
            // (2) Generate random password --> hash
            $password = $page->random_password();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            // (3) Update customer or admin record
            $table = $user->role;
            $stm = $pdo->prepare("UPDATE $table SET hash = ? WHERE username = ?");
            $stm->execute([$hash, $username]);
            
            // (4) Send email
            $ok = $page->email($email, 'Password Reset', "
                <p>Dear $user->name,</p>
                <p>Your password has been reset to:</p>
                <h1>$password</h1>
                <p>Please <a href='http://localhost:8000/account/login.php'>login</a> using your new password.</p>
                <p>From Admin</p>
            ");
                        
            if ($ok) {
                $page->temp('success', 'Password reset. Please check your email.');
                $page->redirect('login.php');
            }
            else {
                $err['email'] = 'Failed to send email.';    
            }
        }
        else {
            $err['email'] = 'Email not matched.';
        }
    }
}

$page->title = 'Reset Password';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<form method="post">
    <div class="form">
        <h2>Reset Password</h2>
        <fieldset>
<!--        <div>
            <label for="username">Username</label>
            <?php $html->text('username', $username) ?>
            <?php $html->error($err, 'username') ?>
        </div>-->
        
        <div>
            <label for="email">Email</label>
            <?php $html->text('email', $email) ?>
            <?php $html->error($err, 'email') ?>
        </div>
        </fieldset>
    </div>
    
    <button>Reset Password</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('username', $err);
$page->footer();
?>