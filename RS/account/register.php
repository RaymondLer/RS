<?php
include'../_config.php';
echo '<link rel="stylesheet" href="/css/account/register.css">';
echo '<link rel="stylesheet" href="/css/header.css">';

$username = $password = $confirm = $name = $email = $phone = $gender = '';
$err = [];
$pdo = $page->pdo();

// Lookup arrays
$arr_gender = [
    'F' => 'Female',
    'M' => 'Male'
];

if ($page->is_post()) {
    $username = $page->post('username');
    $password = $page->post('password');
    $confirm = $page->post('confirm');
    $name = $page->post('name');
    $email = $page->post('email');
    $phone = $page->post('phone');
    $gender = $page->post('gender');

    if ($username == '') {
        $err['username'] = 'Username is required.';
    } else if (strlen($username) > 20) {
        $err['username'] = 'Username must not more than 20 characters.';
    } else {
        // Check if username is duplicated
        $stm = $pdo->prepare("SELECT COUNT(*) FROM customer WHERE username = ?");
        $stm->execute([$username]);
        $count = $stm->fetchColumn();

        if ($count > 0) {
            $err['username'] = 'Username duplicated. Try another.';
        }
    }

    if ($password == '') {
        $err['password'] = 'Password is required.';
    } else if (strlen($password) < 5) {
        $err['password'] = 'Password must more than 5 characters.';
    } else if (!preg_match('/^\S+$/', $password)) {
        $err['password'] = 'Password should not contain spaces.';
    }

    if ($confirm == '') {
        $err['confirm'] = 'Confirm Password is required.';
    } else if ($confirm != $password) {
        $err['confirm'] = 'Confirm Password and Password not matched.';
    }

    if ($name == '') {
        $err['name'] = 'Name is required.';
    } else if (strlen($name) > 100) {
        $err['name'] = 'Name must not more than 100 characters.';
    }

    if ($email == '') {
        $err['email'] = 'Email is required.';
    } else if (strlen($email) > 100) {
        $err['email'] = 'Email no more than 100 characters.';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $err['email'] = 'Email format invalid.';
    }

    if ($phone == '') {
        $err['phone'] = 'Phone is required.';
    } else if (!preg_match('/^01\d-\d{7,8}$/', $phone)) {
        $err['phone'] = 'Phone format invalid.';
    }

    if ($gender == '') {
        $err['gender'] = '[Gender] cannot empty.';
    } else if (!preg_match('/^[FM]$/', $gender)) {
        $err['gender'] = '[Gender] invalid.';
    }

    if (!$err) {
        // Password hash
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert customer record
        $stm = $pdo->prepare("
            INSERT INTO customer (username, hash, name, email, phone, gender)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stm->execute([$username, $hash, $name, $email, $phone, $gender]);

        $page->temp('success', 'Account registered. Please login.');
        $page->redirect('login.php');
    }
}

$page->title = 'Registration';
$page->header();
?>

<body>
    <section>
        <form action="register.php" method="post" id="input">
            <h2>Register</h2>
            <div class="form">
                <div class="register">
                    <label for="username">Username :</label>
                    <?php $html->text('username', $username, 20) ?> 
                    <?php $html->error($err, 'username') ?>
                </div>

                <div class="register">
                    <label for="password">Password :</label>
                    <?php $html->password('password', $password, 20) ?>
                    <?php $html->error($err, 'password') ?>
                </div>

                <div class="register">
                    <label for="confirm">Confirm Password :</label>
                    <?php $html->password('confirm', $confirm, 20) ?>
                    <?php $html->error($err, 'confirm') ?>
                </div>

                <div class="register">
                    <label for="name">Name :</label>
                    <?php $html->text('name', $name, 100) ?>
                    <?php $html->error($err, 'name') ?>
                </div>

                <div class="register">
                    <label for="email">Email Address :</label>
                    <?php $html->text('email', $email, 100) ?>
                    <?php $html->error($err, 'email') ?>
                </div>

                <div class="register">
                    <label for="phone">Phone :</label>
                    <?php $html->text('phone', $phone, 12) ?>
                    <?php $html->error($err, 'phone') ?>
                </div>

                <div class="register">
                    <label for="gender">Gender :</label>
                    <?php $html->radio_list('gender', $arr_gender) ?>
                    <?php $html->error($err, 'gender') ?>
                </div>
            </div>

            <div style="text-align: center;">
                <button class="btn">Register</button>      
                <button type="reset" class="btn">Reset</button>
            </div>
        </form>
    </section>
</body>

<?php
$html->focus('username', $err);
$page->footer();
?>