<?php
include'../../_config.php';
$page->authorize('admin');
$username = $password = $confirm = $name = $email = '';
$err = [];
$pdo = $page->pdo();

if($page->is_post()) {
    $username = $page->post('username');
    $password = $page->post('password');
    $confirm  = $page->post('confirm');
    $name     = $page->post('name'); 
    $email    = $page->post('email');
    
    if($username == '') {
        $err['username'] = 'Username is required.';
    }
    else if(strlen($username) > 20) {
        $err['username'] = 'Username must not more than 20 characters.';
    }

    else {
        // Check if username is duplicated
        $stm = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = ?");
        $stm->execute([$username]);
        $count = $stm->fetchColumn();

        if ($count > 0) {
            $err['username'] = 'Username duplicated. Try another.';
        }
    }

    if($password == '') {
        $err['password'] = 'Password is required.';
    }

    else if(strlen($password) < 5) {
        $err['password'] = 'Password must more than 5 characters.';
    }
    else if(!preg_match('/^\S+$/', $password)) {
        $err['password'] = 'Password should not contain spaces.';
    }

    if($confirm == '') {
        $err['confirm'] = 'Confirm Password is required.';
    }
    else if($confirm != $password) {
        $err['confirm'] = 'Confirm Password and Password not matched.';
    }
    
    if($name == '') {
        $err['name'] = 'Name is required.';
    }
    else if(strlen($name) > 100) {
        $err['name'] = 'Name must not more than 100 characters.';
    }

    if($email == '') {
        $err['email'] = 'Email is required.';
    }
    else if(strlen($email) > 100) {
        $err['email'] = 'Email no more than 100 characters.';
    }
    else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $err['email'] = 'Email format invalid.';
    }
    
    if(!$err) {
        // Password hash
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert customer record
        $stm = $pdo->prepare("
            INSERT INTO admin (username, hash, name, email)
            VALUES (?, ?, ?, ?)
        ");
        $stm->execute([$username, $hash, $name, $email]);
    }
}

$page->title = 'Register Admin';
$page->header();
?>

<form action="admin_register.php" method="post">
    <div class="form">
        <h1>Register - Admin</h1>
        <fieldset>
            <div>
                <label for="username">Username :</label>
                <?php $html->text('username', $username, 20) ?>
                <?php $html->error($err, 'username') ?>
            </div>

            <div>
                <label for="password">Password :</label>
                <?php $html->password('password', $password, 20) ?>
                <?php $html->error($err, 'password') ?>
            </div>

            <div>
                <label for="confirm">Confirm Password :</label>
                <?php $html->password('confirm', $confirm, 20) ?>
                <?php $html->error($err, 'confirm') ?>
            </div>
            
            <div>
                <label for="name">Name :</label>
                <?php $html->text('name', $name, 100) ?>
                <?php $html->error($err, 'name') ?>
            </div>
            
             <div>
                <label for="email">Email Address :</label>
                 <?php $html->text('email', $email, 100) ?>
                 <?php $html->error($err, 'email') ?>
            </div>
        </fieldset>
    </div>
    
    <button>Register</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('username', $err);
$page->footer();
?>